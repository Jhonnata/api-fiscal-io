<?php

namespace API\NumberInWords\Controllers;

use API\NumberInWords\Services\NumberInWordsService;
use App\Controllers\ApiController;
use Exception;

class NumberInWords extends ApiController
{

    /**
     * @OA\Get (
     *     tags={"NumberInWords"},
     *     summary="Get a NumberInWords.",
     *     description="Write the number in full, for example: One, two..",
     *     path="/number-in-words/{number}",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="number",
     *         in="path",
     *         description="Number for get name",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="422", description="Missing Data"),
     *     @OA\Response(response="401", description="Unauthorized"),
     * )
     */
    public function index($number = null)
    {
        try {
            if (!is_numeric($number)) {
                throw  new Exception(lang('Messages.notNumber'));
            }
            $numberInWord = new NumberInWordsService();
            return $this->respond($numberInWord->translate($number));
        } catch (\Throwable $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function show($id = null)
    {
        return parent::show($id); // TODO: Change the autogenerated stub
    }

    public function new()
    {
        return parent::new(); // TODO: Change the autogenerated stub
    }

    public function create()
    {
        return parent::create(); // TODO: Change the autogenerated stub
    }

    public function edit($id = null)
    {
        return parent::edit($id); // TODO: Change the autogenerated stub
    }

    public function update($id = null)
    {
        return parent::update($id); // TODO: Change the autogenerated stub
    }

    public function delete($id = null)
    {
        return parent::delete($id); // TODO: Change the autogenerated stub
    }


}
