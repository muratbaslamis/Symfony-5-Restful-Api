<?php

namespace App\Repository;

use App\Entity\Siparisler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Siparisler>
 *
 * @method Siparisler|null find($id, $lockMode = null, $lockVersion = null)
 * @method Siparisler|null findOneBy(array $criteria, array $orderBy = null)
 * @method Siparisler[]    findAll()
 * @method Siparisler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiparislerRepository extends ServiceEntityRepository
{

    /**
     * @ORM\Column(type="string")
     */
    private $manager;


    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Siparisler::class);
        $this->manager = $manager;

    }

    public function siparisekle($orderCode,  $productid, $quantity, $address, $shippingDate, $kullaniciid)
    {
        $siparis = new Siparisler();


        $siparis
            ->setOrderCode($orderCode)
            ->setProductid($productid)
            ->setQuantity($quantity)
            ->setAddress($address)
            ->setShippingDate($shippingDate)
            ->setKullaniciid($kullaniciid);

        $this->manager->persist($siparis);
        $this->manager->flush();
    }


//    public function siparisguncelle($id, $orderCode, $productid, $quantity, $address, $shippingDate, $kullaniciid)
//    {
//        $siparis = new Siparisler();
//
//        $siparis
//            ->setId($id)
//            ->setOrderCode($orderCode)
//            ->setProductid($productid)
//            ->setQuantity($quantity)
//            ->setAddress($address)
//            ->setShippingDate($shippingDate)
//            ->setKullaniciid($kullaniciid);
//
//        $this->getEntityManager()->merge($siparis);
//        $this->getEntityManager()->flush();
//    }
    public function guncelle(Siparisler $siparisler): Siparisler
    {
        $this->manager->persist($siparisler);
        $this->manager->flush();

        return $siparisler;
    }

    // public function remove(Siparisler $entity, bool $flush = false): void
    // {
    //     $this->getEntityManager()->remove($entity);

    //     if ($flush) {
    //         $this->getEntityManager()->flush();
    //     }
    // }

//    /**
//     * @return Siparisler[] Returns an array of Siparisler objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Siparisler
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
