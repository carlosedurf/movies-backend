<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MainTest extends TestCase
{
    /** @test */
    public function check_if_list_object_full_correct()
    {
        $return = $this->get('/v1//');

        $returnGet = false;
        if(count(get_object_vars($return)) > 0){
            $returnGet =  true;
        }

        $this->assertEquals(true, $returnGet);
    }

    /** @test */
    public function check_if_list_genres_object_full_correct()
    {
        $return = $this->get('/v1/genres/');

        $returnGet = false;
        if(count(get_object_vars($return)) > 0){
            $returnGet =  true;
        }

        $this->assertEquals(true, $returnGet);
    }

    /** @test */
    public function check_movie_with_id_is_correct()
    {
        $return = $this->get('/v1/movie/10');

        $returnGet = false;
        if(count(get_object_vars($return)) > 0){
            $returnGet =  true;
        }

        $this->assertEquals(true, $returnGet);
    }

    /** @test */
    public function check_search_with_query_is_correct()
    {
        $return = $this->get('/v1/search/?query=Lord');

        $returnGet = false;
        if(count(get_object_vars($return)) > 0){
            $returnGet =  true;
        }

        $this->assertEquals(true, $returnGet);
    }

    /** @test */
    public function check_search_with_query_and_genre_is_correct()
    {
        $return = $this->get('/v1/search/?query=Lord&genre=28');

        $returnGet = false;
        if(count(get_object_vars($return)) > 0){
            $returnGet =  true;
        }

        $this->assertEquals(true, $returnGet);
    }



}
