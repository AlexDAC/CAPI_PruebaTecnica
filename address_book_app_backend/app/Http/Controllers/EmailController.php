<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\QueryHelper;
use App\Http\Requests\UpsertEmailRequest;
use App\Models\Contact;
use App\Models\Email;
use App\Repositories\emails\ReadEmailInterface;
use App\Repositories\emails\WriteEmailInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

class EmailController extends Controller
{
    private writeEmailInterface $writeEmailInterface;
    private ReadEmailInterface $readEmailInterface;
    
    public function __construct(WriteEmailInterface $writeEmailInterface, ReadEmailInterface $readEmailInterface)
    {
        $this->readEmailInterface = $readEmailInterface;
        $this->writeEmailInterface = $writeEmailInterface;
    }

    /**
     * Get all emails associated with the contact
     *
     * @param int $contactId
     * @param Request $request
     * 
     * @return JsonResponse $response
     *
     * @method GET
     * @route /api/contacts/{contact}/emails
     * @name contact_emails.index
     * 
     */
    public function index(int $contactId, Request $request)
    {
        try {
            $queryFilters = QueryHelper::ExtractQueryFiltersFromRequest($request);
            $emails = $this->readEmailInterface->getAll($contactId, $queryFilters);
            return ApiResponse::success(['emails' => $emails]);
        } catch (Exception | Error $e) {
            return ApiResponse::unprocessable(null, null, $e->getMessage());
        }
    }

    /**
     * Get a single email from database
     *
     * @param Email $email
     * 
     * @return JsonResponse $response
     *
     * @method GET
     * @route /api/contacts/emails/{email}
     * @name contact_emails.show
     *
     */
    public function show(Email $email)
    {
        try {
            $email = $this->readEmailInterface->getById($email);
            return ApiResponse::success(['email' => $email]);
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }

    /**
     * Create a new email for the contact in the database
     * 
     * @param Contact $contact
     * @param UpsertEmailRequest $request
     * 
     * @return JsonResponse $response
     *
     * @method POST
     * @route /api/contacts/{contact}/emails
     * @name contact_emails.store
     *
     */
    public function store(Contact $contact,UpsertEmailRequest $request)
    {
        try {
            $data = $request->validated();
            $this->writeEmailInterface->store($contact, $data);
            return ApiResponse::created();
        } catch (InvalidArgumentException $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        } 
    }

     /**
     * Update the specified email of the contact in storage.
     * 
     * @param Contact $contact
     * @param UpsertEmailRequest $request
     * 
     * @return JsonResponse $response
     *
     * @method PUT
     * @route /api/contacts/emails/{email}
     * @name contact_emails.update
     *
     */
    public function update(Email $email, UpsertEmailRequest $request)
    {
        try{
            $data = $request->validated();
            $this->writeEmailInterface->update($email, $data);
            return ApiResponse::success();
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }

    /**
     * Delete a specified email of the contact in the database
     *
     * @param Email $email
     * 
     * @return JsonResponse $response
     *
     * @method DELETE
     * @route /api/contacts/emails/{email}
     * @name contact_emails.destroy
     *
     */
    public function destroy(Email $email)
    {
        try {
            $this->writeEmailInterface->delete($email);
            return ApiResponse::success();
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }
}
