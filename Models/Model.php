<?php

namespace App\Models;

use App\Db\Db;
use App\Libs\Validator;
use PDOStatement;

class Model extends Db
{
    /**
     * Table de la base de données
     *
     * @var string
     */
    protected string $table;
    /**
     * Instance de Db pour l'interaction avec PDO et la base de données
     *
     * @var Db
     */
    protected Db $pdo;
    /**
     * Pour la limite des données à avoir
     *
     * @var integer
     */
    protected int $limit;
    protected string $primaryKey = 'id';

    /**
     * Fillable keys it means the keys to be modified
     *
     * @var array
     */
    protected array $fillable = [];

    /**
     * Fillable data it means the data to be modified
     *
     * @var array
     */
    protected array $fillableData = [];

    /**
     * field Tobe Verified for testing if it exists in table
     *
     * @var array
     */
    protected array $verifyFields = [];

    /**
     * Validateur des donnée
     *
     * @var Validator
     */
    public Validator $validator;
    public function __construct()
    {
        $this->validator = new Validator();
    }
    /**
     * Generate an SQL request for SELECT
     *
     * @param array $options
     * @return string
     */
    protected function selectQuery(array $options =
    [
        "order" => "",
        "fields" => "",
        "params" => [],
        "separator" => "AND",
        "limit" => 0
    ]): string
    {

        $sql = "SELECT";

        if (@$this->validator->isNotEmpty($options['fields'])) {
            $sql .= " " . implode(", ", $options['fields']);
        } else {
            $sql .= " *";
        }

        $sql .= " FROM $this->table";

        if (@$this->validator->isNotEmpty($options['params'])) {
            $strParams = "";

            if (is_array($options['params'])) {
                $strParams = $this->getParams($options['params'], $options['separator']);
            } else {
                $strParams = $options['params'];
            }

            $sql .= " WHERE $strParams";
        }

        if (@$this->validator->isNotEmpty($options['order'])) {
            $sql .= " {$options['order']}";
        }

        if (@$this->validator->isNotEmpty($options['limit'])) {
            $sql .= " LIMIT {$options['limit']}";
        }

        return trim($sql);
    }

    public function create(Model|array $attributes = [], $hydate = false)
    {
        $params = [];
        if (empty($attributes)) {
            $attributes = $this;
        }

        if ($hydate) {
            $this->hydrateData($attributes);
        }
        $params = $this->fillableData;

        $dataParams = $this->getParamsValues($params, ', ', true);
        $values = $dataParams[0];
        $params = $dataParams[1];

        $keys = implode(', ', array_keys($params));
        $searchParam = $this->getVerifiedFieldData($this);
        $query = $this->findBy($searchParam, false, 'OR');

        if (is_bool($query)) {
            $sql = "INSERT INTO $this->table($keys) VALUES($values)";
            $this->makeQuery($sql, $params);
        } else {
            debugPrint("La donnée existe déjà");
        }
    }
    public function delete(int $id)
    {
        $params = ['id' => $this->validator->validFieldData($id)];
        $sql = "DELETE FROM $this->table WHERE id=:id";
        $result = $this->makeQuery($sql, $params);
        debugPrint($result->fetch());
        if (!is_bool($result)) {
            debugPrint("Données supprimer avec succés");
        }
    }
    public function update(int $id, Model|array $attributes = [], $hydate = false)
    {
        $params = [];
        if (empty($attributes)) {
            $attributes = $this;
        }

        if ($hydate) {
            $this->hydrateData($attributes);
        }
        $params = $this->fillableData;

        $dataParams = $this->getParamsValues($params, ',', false);
        $values = $dataParams[0];
        $params = $dataParams[1];

        $searchParam = [$this->primaryKey => $id];
        $query = $this->findBy($searchParam, false, 'OR');
        $params['id'] = $id;
        debugPrint($searchParam);
        if (!is_bool($query)) {

            $sql = "UPDATE $this->table SET $values WHERE id=:id";
            $this->makeQuery($sql, $params);
        } else {
            debugPrint("La donnée n'existe déjà");
        }
    }
    protected function getVerifiedFieldData(array|Model $params): array
    {
        $verifyDataFields = [];
        foreach ($params as $key => $v) {

            if (in_array($key, $this->verifyFields) && $v) {
                $verifyDataFields[$key] = $this->validator->validFieldData($v);
            }
        }
        return $verifyDataFields;
    }
    /**
     * Get Data in the database
     * @param string $all To get all data or a single data
     */
    public function findAll($all = true): PDOStatement | array| null
    {
        $sql =  $this->selectQuery();
        $query = $this->makeQuery($sql);

        return $this->getStatementData($query, $all);
    }
    public function hydrateData(Model |array $data): self
    {

        foreach ($data as $key => $v) {
            if (in_array($key, $this->fillable)) {
                $method = "set" . ucfirst(strval($key));
                if (method_exists($this, $method)) {
                    $v = $this->validator->validFieldData($v);
                    $this->$method($v);
                }
            }
        }
        $this->fillFillable();
        return $this;
    }
    protected function fillFillable()
    {
        foreach ($this as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->fillableData[$key] = $value;
            }
        }
    }
    /**
     * Get
     *
     * @param array $params
     * @param boolean $all
     * @return array|bool
     */
    public function findBy(array $params, $all = true, string $separator = 'AND'): array| bool
    {
        $paramsData = $this->getParamsValues($params, $separator);
        $strparams = $paramsData[0];
        $params = $paramsData[1];

        $sql = $this->selectQuery(['params' => $strparams]);
        $query = $this->makeQuery($sql, $params);
        return $this->getStatementData($query, $all);
    }

    public function find(array |int $params): array|bool
    {
        if (!is_array($params)) {
            $params = ["$this->primaryKey" => $params];
        }

        return $this->findBy($params, false);
    }
    /**
     * Recupère les paramètres en clé valeur qu'on va utiliser dans la requete
     *
     * @param array $params Les paramètre de la requete
     * @param string $separator le separateur dans la requete
     * @return array
     */
    protected function getParamsValues(array $params, string $separator = "AND", $insert = false): array
    {
        $separator = " $separator ";
        $keys = [];

        foreach ($params as $k => $val) {
            if ($insert) {
                $keys[] = ":$k";
            } else {
                $keys[] = "$k=:$k";
            }
            $params[$k] = $this->validator->validFieldData($val);
        }
        $strparams = implode($separator, $keys);
        return [$strparams, $params];
    }

    /**
     * Retourne the params of the request
     *
     * @param array $params Params of request
     * @param string $separator The string separator in params
     * @return string
     */
    public function getParams(array $params, string $separator = " AND "): string
    {

        $keys = [];
        foreach ($params as $k => $val) {
            $keys[] = "$k=:$k";
        }
        return implode($separator, $keys);
    }

    /**
     * Execute une requete SQL
     *
     * @param string $sql la requete à executer
     * @param array $attribute Les attribus à mettre dans la requete
     * @return  PDOStatement|bool
     */
    protected function makeQuery(string $sql, array $attributes = []): PDOStatement|bool
    {
        $this->pdo =  Db::getPDO();
        // On verifie si on a des attributs
        if (!empty($attributes)) {
            // Requete preparer
            $query = $this->pdo->prepare($sql);
            $query->execute($attributes);
            return $query;
        }
        return $this->pdo->query($sql);
    }
    protected function getStatementData(PDOStatement | bool $query, $all = true): array | bool
    {
        if ($query instanceof PDOStatement) {

            if ($all) {
                return $query->fetchAll();
            }
            return $query->fetch();
        }

        return $query;
    }

    /**
     * Set pour la limite des données à avoir
     *
     * @param  integer  $limit  Pour la limite des données à avoir
     *
     * @return  self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }
    public function slugify(string $value): string
    {
        $value = $this->validator->validFieldData($value);
        return strtolower(trim(preg_replace("/\W+/i", '-', $value), '-'));
    }
}
