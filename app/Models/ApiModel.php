<?php

namespace App\Models;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Model;
use Exception;

class ApiModel extends Model
{

    /**
     * @var IncomingRequest
     */
    protected IncomingRequest $request;
    protected array $filters;
    protected string $lastSql;

    public function __construct(?\CodeIgniter\Database\ConnectionInterface &$db = null, ?\CodeIgniter\Validation\ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        helper('api');
        $this->request = \Config\Services::request();
        $this->filters = filter_var_array($this->request->getGet(),FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * @param bool $paginate
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findAllData(bool $paginate = false, int $limit = 10, int $offset = 0): array
    {
        $limit = $this->filters['lmt'] ?? $limit;
        $offset = $this->filters['oft'] ?? $offset;
        if (!empty($this->filters['callback'])) {
            $this->afterFind = [$this->filters['callback']];
        }
        if (!empty($this->filters['noCallback'])) {
            $this->afterFind = [];
        }

        if (!$paginate) {
            $paginate = isset($this->filters['p']) && $this->filters['p'] == 'true';
        }

        if ($paginate) {
            $findAll = $this->paginate($limit);
            $details = $this->pager->getDetails();
            $data = [
                'data' => $findAll,
                'total' => $details['total'] ?? 0,
                'details' => [
                    'total'=>$details['total'],
                    'perPage'=>$details['perPage'],
                    'pageCount'=>$details['pageCount'],
                    'currentPage'=>$details['currentPage'],
                ]
            ];
        } else {
            $data = $this->findAll($limit, $offset);
        }
        if (!empty($this->filters['dev'])) {
            echo $this->db->showLastQuery();
        }
        return $data;
    }

}