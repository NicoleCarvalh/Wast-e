<?php

    require "connection.php";

    if(isset($_SESSION['user_id'])) {
        // Seleciona o usuário de acordo com o id dele (vindo do login)
        $query = "SELECT * FROM $_SESSION[user_type] WHERE user_id = :user_id";
        $stmt = $connection->prepare($query);
    
        $stmt->bindValue(':user_id', $_SESSION['user_id']);
    
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $user = $result[0];

        if($_SESSION['user_type'] == 'person_users') {
            // Seleciona a coleta solicitada pelo usuário
            $query = "SELECT * FROM collections WHERE user_id = :userId";
            $stmt = $connection->prepare($query);

            $stmt->bindValue(':userId', $user->user_id);

            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            if(isset($result[0])) {
                $collection = $result[0];
            } 

        } else if($_SESSION['user_type'] == 'institution_users') {

            if(isset($user->collections_id)) {
                $collectionsList_id = explode(",", $user->collections_id);

                $allCollections_data = [];
                $clientsList_data = [];

                // Percorre toda a lista de id's das coletas
                for($i = 0; $i < count($collectionsList_id); $i++) {

                    // Transforma o id da coleta em inteiro
                    $collection = intval($collectionsList_id[$i]);
            
                    $query = "SELECT * FROM collections WHERE collection_id = $collection";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                
                    $collection = $stmt->fetchAll(PDO::FETCH_OBJ);

                    // Pega todos os dados da coleta e adiciona ao array "$allCollections_data"
                    array_push($allCollections_data, $collection);


                    // Pega o id do usuario que solicitou a coleta, a partir do id do usuario
                    $requestingUser = $collection[0]->user_id;
                    $query = "SELECT * FROM person_users WHERE user_id = $requestingUser";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                
                    $requestingUsers = $stmt->fetchAll(PDO::FETCH_OBJ);

                    // Pega todos os dados do cliente que solicitou a coleta e adiciona ao array "$clientsList_data"
                    array_push($clientsList_data, $requestingUsers);
                }
            }

            $allCollectionsConfirmed = explode(',', $user->collections_id_confirmed);

            $allCollections_data_confirmed = [];
            $allClients_data_confirmed = [];


            for($i = 0; $i < count($allCollectionsConfirmed); $i++) {
                $query = "SELECT * FROM collections WHERE collection_id = :collectionId";
                $stmt = $connection->prepare($query);

                $stmt->bindValue(':collectionId', $allCollectionsConfirmed[$i]);

                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                array_push($allCollections_data_confirmed, $result);


                $query = "SELECT * FROM person_users WHERE collection_id = :collectionId";
                $stmt = $connection->prepare($query);

                $stmt->bindValue(':collectionId', $allCollectionsConfirmed[$i]);

                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                array_push($allClients_data_confirmed, $result);
            }

            // Selecionando a coleta e o usuário em foco
            
    
            if(isset($_SESSION['collection_id_focus'])) {
                $query = "SELECT * FROM collections WHERE collection_id = :collectionId";
                $stmt = $connection->prepare($query);

                $stmt->bindValue(':collectionId', $_SESSION['collection_id_focus']);

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                $collectionFocus = $result[0];


                
                $query = "SELECT * FROM person_users WHERE user_id = :userId";
                $stmt = $connection->prepare($query);
        
                $stmt->bindValue(':userId', $collectionFocus->user_id);
            
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                $userFocus = $result[0];
            }

        }

        // Seleciona todas as empresas

        $query = "SELECT * FROM institution_users";
        $stmt = $connection->prepare($query);
    
        $stmt->execute();
        $allInstitutionUsers = $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        header('Location: login.html');
    }
?>