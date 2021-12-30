<?php

    if(isset($_SESSION["userid"])) {

        $haikuID = $_POST["haikuid"];
        $userID = $_POST["userid"];
        $authorID = $_POST["authorid"];

        $dwk = 'SELECT * FROM likes';
        $stmn = $pdo->query($dwk);
        $alreadyLikes = $stmn->fetchAll();

        function alreadyLiked(array $arr) {
            
            global $haikuID, $userID, $authorID;
            
            foreach($arr as $e) {
                if($userID === $e->user_id &&
                    $haikuID === $e->haiku_id && 
                    $authorID === $e->author_id) {
                        return true;
                    }
                    
                    return false; 
                }
                
            }
            
            if(alreadyLiked($alreadyLikes) == false) {
                $dwq = "INSERT INTO likes(user_id, haiku_id, author_id) VALUES(:user_id, :haiku_id, :author_id)";
                $shmn = $pdo->prepare($dwq);
                $shmn->execute(["user_id" => $userID, "haiku_id" => $haikuID, "author_id" => $authorID]);
            } elseif(alreadyLiked($alreadyLikes) == true) {
                $error = 'There was an error processing your request';
            }
            
    } else {
        header("location: login.php");
    }

?>