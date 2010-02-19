<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class BlogTable extends Doctrine_Table
{
    public function getBlogForVoting($exclusion_list)
    {
        $q = $this->createQuery()
        ->select('*')
        ->from('Blog b')
        ->where('b.is_thumbnail = ?', 1)
        ->andWhereNotIn('b.id', $exclusion_list)
        ->groupBy('b.id')
        ->orderBy('vote_count ASC,created_at DESC')
        ->limit(1);
        
        
        
     /* ->select ('min(a.id) as min_id,a.id, b.*')
        ->from('Blog a')
        ->innerJoin('a.Blog b')
        ->where('a.is_thumbnail = ?', 1)
        ->andWhereNotIn('a.id', $exclusion_list)
        ->groupBy('a.vote_count')
        ->orderBy('a.vote_count ASC')
        ->limit(1);
        */
        return $q->execute();
    }
}