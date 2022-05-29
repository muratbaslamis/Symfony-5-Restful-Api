<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Siparisler;
use App\Repository\SiparislerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SiparislerController
 * @package App\Controller
 *
 * @Route(path="/api/siparisler")
 */

class SiparislerController extends AbstractController
{


    private $siparislerRepository;
    private $jwtEncoder;
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager, SiparislerRepository $siparislerRepository, JWTEncoderInterface $jwtEncoder)
    {
                $this->siparislerRepository = $siparislerRepository;
        $this->jwtEncoder = $jwtEncoder;
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/ekle", name="ekle", methods={"POST"})
     */
    public function ekle(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $userid = $this->getUseridFromJWT($request);
        $shippingDate = \DateTime::createFromFormat('Y-m-d','2022-05-30');
        $siparis = new Siparisler();
        $siparis->setKullaniciid($userid);
        $siparis->setOrderCode($data['orderCode']);
        $siparis->setProductid($data['productid']);
        $siparis->setAddress($data['address']);
        $siparis->setQuantity($data['quantity']);
        $siparis->setShippingDate($shippingDate);

        $this->entityManager->persist($siparis);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Sipariş eklendi'], Response::HTTP_CREATED);
    }


    /**
     * @Route("/guncelle/{id}", name="siparisguncelle", methods={"PUT"})
     */
    public function guncelle($id, Request $request): JsonResponse
    {
        $userid = $this->getUseridFromJWT($request);
        $siparis = $this->siparislerRepository->findOneBy(['id' => $id,'kullaniciid'=>$userid]);

        if(!isset($siparis)){
            return new JsonResponse(['status' => 'Sipariş Bulunamadı'], Response::HTTP_CREATED);
        }


        $data = json_decode($request->getContent(), true);

        $kargotarihi = $siparis->getShippingDate();
        $simdikitarih = new \DateTime();

        if($kargotarihi <= $simdikitarih){
            return new JsonResponse(['status' => 'Siparişin kargo süresi geçmiş.'], Response::HTTP_CREATED);
        }

        if(empty($data)){

            return new JsonResponse(['status' => 'Gerekli alanları doldurunuz.'], Response::HTTP_CREATED);

        }

        empty($data['orderCode']) ? true : $siparis->setOrderCode($data['orderCode']);
        empty($data['productid']) ? true : $siparis->setProductid($data['productid']);
        empty($data['quantity']) ? true : $siparis->setQuantity($data['quantity']);
        empty($data['address']) ? true : $siparis->setAddress($data['address']);



        $siparisguncelle = $this->siparislerRepository->guncelle($siparis);

        return new JsonResponse(['status' => 'Sipariş güncellendi'], Response::HTTP_CREATED);
    }


    /**
     * @Route("/detay/{id}", name="detay", methods={"GET"})
     */
    public function detay($id, Request $request): JsonResponse
    {
        $userid = $this->getUseridFromJWT($request);
        $siparis = $this->siparislerRepository->findOneBy(['id' => $id,'kullaniciid'=>$userid]);

        if (empty($siparis)) {
            return new JsonResponse(['status' => 'Sipariş bulunamadı.'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $siparis->getId(),
            'orderCode' => $siparis->getOrderCode(),
            'productid' => $siparis->getProductid(),
            'quantity' => $siparis->getQuantity(),
            'address' => $siparis->getAddress(),
            'shippingdate' => $siparis->getShippingDate(),
        ], Response::HTTP_CREATED);
    }

    /**
     * @Route("/siparislerim", name="siparislerim", methods={"GET"})
     */
    public function siparislerim(Request $request): JsonResponse
    {
                $userid = $this->getUseridFromJWT($request);
        $siparisler = $this->siparislerRepository->findBy(array('kullaniciid'=>$userid));
        $data = [];

        foreach ($siparisler as $siparis) {
            $data[] = [
                'id' => $siparis->getId(),
                'orderCode' => $siparis->getOrderCode(),
                'productid' => $siparis->getProductid(),
                'quantity' => $siparis->getQuantity(),
                'address' => $siparis->getAddress(),
                'shippingdate' => $siparis->getShippingDate()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

        private function getUseridFromJWT(Request $request)
    {


        $token = $request->headers->get('Authorization');
        $token = explode("Bearer ", $token); 
        $username = $this->jwtEncoder->decode($token[1])['username'];
        $userid = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('username' => $username))->getId();
        return $userid;
    }

}
