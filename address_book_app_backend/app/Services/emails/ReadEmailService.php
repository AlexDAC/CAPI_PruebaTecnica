<?php

namespace App\Services\emails;

use App\Helpers\QueryHelper;
use App\Models\Email;
use App\Repositories\emails\ReadEmailInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ReadEmailService implements ReadEmailInterface
{
    /**
     * Get all the email of a contact from the database.
     *
     * @param int $contactId
     * @param mixed $queryFilters
     * 
     * @return LengthAwarePaginator $emails
     */
    public function getAll(int $contactId, array $queryFilters): LengthAwarePaginator
    {
        $emailQuery = Email::where('contact_id', $contactId);

        $emailQuery = QueryHelper::querySearch(
            $emailQuery,
            $queryFilters['searchBy'],
            [
                'email'
            ],
        );

        if ($queryFilters['sortOrder'] == '' || $queryFilters['sortBy'] == '') {
            $emailQuery->orderBy('emails.created_at', 'desc');
        } else {
            $emailQuery = QueryHelper::querySort(
                $emailQuery,
                $queryFilters['sortBy'],
                $queryFilters['sortOrder'],
                'emails',
            );
        }

        return $emailQuery->paginate($queryFilters['pageSize'] ? $queryFilters['pageSize'] : 20);
    }
    /**
     * Get a specific email from the database by its identifier
     *
     * @param   Email $emails
     *
     * @return Email $emails
     */    
    public function getById(Email $emails): Email
    {
        return $emails;
    }

}
