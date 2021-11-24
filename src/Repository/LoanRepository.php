<?php

namespace App\Repository;

use App\Entity\Loan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Loan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Loan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Loan[]    findAll()
 * @method Loan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loan::class);
    }

    /**
     * @param array $criteria Array of field with filters
     * @return Loan[] Returns an array of Loan objects
     */
    public function findLoansByCriteria(array $criteria) {
        /* If values are null remove them */
        $status = $criteria['status'];
        $criteria = $this->_remove_blank_filters($criteria);
        $criteriaFromKeys = [
            'fromDate' => null,
            'fromDateOfLoan' => null,
            'fromDateOfReturn' => null,
        ];
        $criteriaToKeys = [
            'toDate' => null,
            'toDateOfLoan' => null,
            'toDateOfReturn' => null,
        ];
        $criteriaAndKeys = [
            'askedBy' => null,
            'signature' => null,
        ];
        $criteriaFrom = null; $criteriaAnd = null; $criteriaTo = null;
        if ( $criteria !== null ) {
            $criteriaFrom = array_intersect_key($criteria,$criteriaFromKeys);
            $criteriaTo = array_intersect_key($criteria,$criteriaToKeys);
            $criteriaAnd = array_intersect_key($criteria,$criteriaAndKeys);
        }
        return $this->findLoansByCriteriaQB($criteriaFrom, $criteriaTo, $criteriaAnd, $status)->getQuery()->getResult();
    }

    private function findLoansByCriteriaQB($criteriaFrom, $criteriaTo, $criteriaAnd, $status = null) {
        $qb = $this->createQueryBuilder('l');
        if ( $criteriaFrom ) {        
            foreach ( $criteriaFrom as $fromField => $value ) {
                $fieldName = str_replace('fromD', 'd', $fromField);
                $qb->andWhere('l.'.$fieldName.' >= :'.$fieldName)
                    ->setParameter($fieldName, $value);
            }
        }
        if ( $criteriaTo ) {        
            foreach ( $criteriaTo as $toField => $value ) {
                $fieldName = str_replace('toD', 'd', $toField);
                $qb->andWhere('l.'.$fieldName.' <= :'.$fieldName.'To')
                    ->setParameter($fieldName.'To', $value->add(new \DateInterval('P1D')));
            }
        }
        if ( $criteriaAnd ) {        
            foreach ( $criteriaAnd as $andField => $value ) {
                $qb->andWhere('l.'.$andField.' = :'.$andField)
                    ->setParameter($andField, $value);
            }
        }
        if ($status !== null) {
            switch ($status) {
                case 'notReturned':
                    $qb->andWhere('l.dateOfReturn is null');
                    break;
                case 'asked':
                    $qb->andWhere('l.date is not null');
                    break;
                case 'loaned':
                    $qb->andWhere('l.dateOfLoan is not null');
                    break;
                case 'returned':
                    $qb->andWhere('l.dateOfReturn is not null');
                    break;
                }
        }
        $qb->orderBy('l.id', 'DESC');
        return $qb;        
    }

    private function _remove_blank_filters($criteria)
    {
        $new_criteria = [];
        foreach ($criteria as $key => $value) {
            if (!empty($value)) {
                $new_criteria[$key] = $value;
            }
        }

        return $new_criteria;
    }

    // /**
    //  * @return Loan[] Returns an array of Loan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Loan
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
