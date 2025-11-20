<?php

namespace App\Controller;

use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/compte')]
class MemberController extends AbstractController
{
    #[Route('', name: 'member_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        /** @var Member $member */
        $member = $this->getUser();
        if (!$member) {
            return $this->redirectToRoute('app_login');
        }

        $collection = $member->getCollectionVoitures();
        $voitures   = $collection ? $collection->getVoitures() : [];
        $galeries   = $member->getGaleries();

        return $this->render('member/dashboard.html.twig', [
            'member'     => $member,
            'collection' => $collection,
            'voitures'   => $voitures,
            'galeries'   => $galeries,
        ]);
    }
}
