<?php

namespace Tests\Repositories\Adhesions;

use Pagos360\Models\Adhesion;
use Pagos360\Repositories\AdhesionRepository;
use Tests\AbstractTestCase;

class CancelledTest extends AbstractTestCase
{
    const STATE_COMMENT = "Cancelado por el usuario";

    /**
     * @var array
     */
    private $mockedResponse = [
        'id' => 1,
        'external_reference' => "098091",
        'adhesion_holder_name' => "Lorem Ipsum",
        'email' => "no-reply@pagos360.com",
        'cbu_holder_name' => "Lorem Ipsum",
        'cbu_holder_id_number' => 27126708608,
        'cbu_number' => "2850590940090418135201",
        'bank' => "INDUSTRIAL AND COMMERCIAL BANK OF CHINA (ARGENTINA)",
        'description' => "Mollit consequat consectetur exercitation excepteur",
        'short_description' => "MOLLIT",
        'state' => "canceled",
        'state_comment' => self::STATE_COMMENT,
        'created_at' => "2018-01-18T22:12:27-03:00",
    ];

    /**
     * @test
     */
    public function stateCommentIsPresent()
    {
        $restClient = $this->mockRestClientGet($this->mockedResponse);
        $repo = new AdhesionRepository($restClient);

        $adhesion = $repo->get(2);

        $this->assertInstanceOf(Adhesion::class, $adhesion);
        $this->assertIsString($adhesion->getStateComment());
        $this->assertSame(self::STATE_COMMENT, $adhesion->getStateComment());
    }
}
