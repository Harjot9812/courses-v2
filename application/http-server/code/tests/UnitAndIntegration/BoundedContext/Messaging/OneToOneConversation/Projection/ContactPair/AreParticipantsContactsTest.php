<?php

declare(strict_types=1);

namespace Tests\Galeas\Api\UnitAndIntegration\BoundedContext\Messaging\OneToOneConversation\Projection\ContactPair;

use Galeas\Api\BoundedContext\Messaging\OneToOneConversation\Projection\ContactPair\AreParticipantsContacts;
use Galeas\Api\BoundedContext\Messaging\OneToOneConversation\Projection\ContactPair\ContactPair;
use PHPUnit\Framework\Assert;
use Tests\Galeas\Api\UnitAndIntegration\KernelTestBase;

class AreParticipantsContactsTest extends KernelTestBase
{
    /**
     * @test
     *
     * @throws \Exception
     */
    public function testAreParticipantsContacts(): void
    {
        $areParticipantsContacts = $this->getContainer()
            ->get(AreParticipantsContacts::class);

        Assert::assertEquals(
            false,
            $areParticipantsContacts->areParticipantsContacts('contact_1', 'contact_2')
        );
        Assert::assertEquals(
            false,
            $areParticipantsContacts->areParticipantsContacts('contact_2', 'contact_3')
        );
        Assert::assertEquals(
            false,
            $areParticipantsContacts->areParticipantsContacts('contact_a', 'contact_b')
        );

        $this->getProjectionDocumentManager()
            ->persist(
                ContactPair::fromProperties(
                    'contact_1_and_contact_2',
                    'contact_1',
                    'contact_2',
                    true
                )
            );
        $this->getProjectionDocumentManager()->flush();

        Assert::assertEquals(
            true,
            $areParticipantsContacts->areParticipantsContacts('contact_1', 'contact_2')
        );
        Assert::assertEquals(
            false,
            $areParticipantsContacts->areParticipantsContacts('contact_2', 'contact_3')
        );
        Assert::assertEquals(
            false,
            $areParticipantsContacts->areParticipantsContacts('contact_a', 'contact_b')
        );

        $this->getProjectionDocumentManager()
            ->persist(
                ContactPair::fromProperties(
                    'contact_2_and_contact_3',
                    'contact_2',
                    'contact_3',
                    true
                )
            );
        $this->getProjectionDocumentManager()->flush();
        Assert::assertEquals(
            true,
            $areParticipantsContacts->areParticipantsContacts('contact_1', 'contact_2')
        );
        Assert::assertEquals(
            true,
            $areParticipantsContacts->areParticipantsContacts('contact_2', 'contact_3')
        );
        Assert::assertEquals(
            false,
            $areParticipantsContacts->areParticipantsContacts('contact_a', 'contact_b')
        );

        $this->getProjectionDocumentManager()
            ->persist(
                ContactPair::fromProperties(
                    'contact_a_and_contact_b',
                    'contact_a',
                    'contact_b',
                    false
                )
            );
        $this->getProjectionDocumentManager()->flush();

        Assert::assertEquals(
            true,
            $areParticipantsContacts->areParticipantsContacts('contact_1', 'contact_2')
        );
        Assert::assertEquals(
            true,
            $areParticipantsContacts->areParticipantsContacts('contact_2', 'contact_3')
        );
        Assert::assertEquals(
            false,
            $areParticipantsContacts->areParticipantsContacts('contact_a', 'contact_b')
        );

        $removeThisPair = $this->getProjectionDocumentManager()
            ->createQueryBuilder(ContactPair::class)
            ->field('id')->equals('contact_2_and_contact_3')
            ->getQuery()
            ->getSingleResult();

        if (false === is_object($removeThisPair)) {
            throw new \Exception();
        }

        $this->getProjectionDocumentManager()->remove($removeThisPair);
        $this->getProjectionDocumentManager()->flush();

        Assert::assertEquals(
            true,
            $areParticipantsContacts->areParticipantsContacts('contact_1', 'contact_2')
        );
        Assert::assertEquals(
            false,
            $areParticipantsContacts->areParticipantsContacts('contact_2', 'contact_3')
        );
        Assert::assertEquals(
            false,
            $areParticipantsContacts->areParticipantsContacts('contact_a', 'contact_b')
        );
    }
}
