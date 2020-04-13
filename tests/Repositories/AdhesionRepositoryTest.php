<?php

namespace Tests\Repositories;

use Pagos360\Models\Adhesion;
use Pagos360\Repositories\AdhesionRepository;
use Tests\AbstractTestCase;

class AdhesionRepositoryTest extends AbstractTestCase
{
    /**
     * @var array
     */
    private $mockedResponse = [
        'id' => 1,
        'external_reference' => "27231",
        'adhesion_holder_name' => "Lorem Ipsum",
        'email' => "no-reply@pagos360.com",
        'cbu_holder_name' => "Lorem Ipsum",
        'cbu_holder_id_number' => 27126708608,
        'cbu_number' => "2850590940090418135201",
        'bank' => "Fugiat reprehenderit",
        'description' => "Mollit consequat consectetur exercitation excepteur",
        'short_description' => "MOLLIT",
        'state' => "signed",
        'created_at' => "2018-01-18T22:12:17-03:00",
    ];

    /**
     * @test
     */
    public function stateCommentIsNullIfNotCancelled()
    {
        $restClient = $this->mockRestClientGet($this->mockedResponse);
        $repo = new AdhesionRepository($restClient);

        $adhesion = $repo->get(1);

        $this->assertInstanceOf(Adhesion::class, $adhesion);
        $this->assertNull($adhesion->getStateComment());
    }
}
