<?php
    //hedears

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';


    //Instante DB si conectare

    $database = new Database();
    $db = $database->connect();


    //Iinstantie blog post

    $post = new Post($db);

    //blog post wuery

    $result = $post->read();

    //Row count

    $num = $result->rowCount();

    //Verificam daca exista postari

    if($num>0){
        //post array
        $posts_arr = array();
        $posts_arr ['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            
            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id ' => $category_id,
                'category_name' => $category_name
            );

            array_push($posts_arr['data'], $post_item);
        }
        //JSON iesiri

        echo json_encode($posts_arr);
        
    } else {
        //Daca nu exista postari
        echo json_encode(
            array('message' => 'Nu exista postari')
        );
    }
