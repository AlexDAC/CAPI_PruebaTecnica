<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\QueryHelper;
use App\Http\Requests\UpsertAddressRequest;
use App\Models\Address;
use App\Models\Contact;
use App\Repositories\addresses\ReadAddressInterface;
use App\Repositories\addresses\WriteAddressInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AddressController extends Controller
{
    private WriteAddressInterface $writeAddressInterface;
    private ReadAddressInterface $readAddressInterface;
    
    public function __construct(
        WriteAddressInterface $writeAddressInterface,
        ReadAddressInterface $readAddressInterface
    )
    {
        $this->readAddressInterface = $readAddressInterface;
        $this->writeAddressInterface = $writeAddressInterface;
    }

    /**
     * Get all addresses associated with the contact
     *
     * @param int $contactId
     * @param Request $request
     * 
     * @return JsonResponse $response
     *
     * @method GET
     * @route /api/contacts/{contact}/addresses
     * @name contact_addresses.index
     * 
     */
    public function index(int $contactId, Request $request)
    {
        try {
            $queryFilters = QueryHelper::ExtractQueryFiltersFromRequest($request);
            $addresses = $this->readAddressInterface->getAll($contactId, $queryFilters);
            return ApiResponse::success(['addresses' => $addresses]);
        } catch (Exception | Error $e) {
            return ApiResponse::unprocessable(null, null, $e->getMessage());
        }
    }

    /**
     * Get a single address from database
     *
     * @param Address $address
     * 
     * @return JsonResponse $response
     *
     * @method GET
     * @route /api/contacts/addresses/{address}
     * @name contact_addresses.show
     *
     */
    public function show(Address $address)
    {
        try {
            $address = $this->readAddressInterface->getById($address);
            return ApiResponse::success(['addresses' => $address]);
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }

    /**
     * Create a new address for the contact in the database
     * 
     * @param Contact $contact
     * @param UpsertAddressRequest $request
     * 
     * @return JsonResponse $response
     *
     * @method POST
     * @route /api/contacts/{contact}/addresses
     * @name contact_addresses.store
     *
     */
    public function store(Contact $contact,UpsertAddressRequest $request)
    {
        try {
            $data = $request->validated();
            $this->writeAddressInterface->store($contact, $data);
            return ApiResponse::created();
        } catch (InvalidArgumentException $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        } 
    }

     /**
     * Update the specified address of the contact in storage.
     * 
     * @param Contact $contact
     * @param UpsertAddressRequest $request
     * 
     * @return JsonResponse $response
     *
     * @method PUT
     * @route /api/contacts/addresses/{address}
     * @name contact_addresses.update
     *
     */
    public function update(Address $address, UpsertAddressRequest $request)
    {
        try{
            $data = $request->validated();
            $this->writeAddressInterface->update($address, $data);
            return ApiResponse::success();
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }

    /**
     * Delete a specified address of the contact in the database
     *
     * @param Address $address
     * 
     * @return JsonResponse $response
     *
     * @method DELETE
     * @route /api/contacts/addresses/{address}
     * @name contact_addresses.destroy
     *
     */
    public function destroy(Address $address)
    {
        try {
            $this->writeAddressInterface->delete($address);
            return ApiResponse::success();
        } catch (Exception | Error $e) {
            return ApiResponse::serverError(null, null, $e->getMessage());
        }
    }
}
