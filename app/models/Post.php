<?php
/**
 * Description of Posts
 *
 * @author Tanvir Anowar
 */


class Post extends Eloquent{
    
    /**
     * Table Name
     * @var string 
     */
    protected $table = 'posts';
    
    
//    protected $guarded = array('id', 'post_id');
    
    public function comment()
    {
        return $this->hasMany('Comment','post_id');
    }
}
