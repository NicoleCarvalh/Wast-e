<?php

    require 'connection.php';

    $formAction = $_GET['action'];

    switch ($formAction) {
        case 'sigin_person':

            $query = "SELECT * FROM person_users WHERE email = :email";

            $stmt = $connection->prepare($query);
            $stmt->bindValue(':email', $_POST['email']);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            if(count($result) >= 1) {
                header('Location: ../../pages/signin.html?UsuarioExiste');
            } else {

                $query = "INSERT INTO person_users(email, password, name, surname, telephone, birth, cep, street, numberHouse, complementHouse, neighborhood, city, federativeUnit) VALUES ( :email, :password, :name, :surname, :telephone, :birth, :cep, :street, :numberHouse, :complementHouse, :neighborhood, :city, :federativeUnit)";
        
                $stmt = $connection->prepare($query);
            
                $stmt->bindValue(':email', $_POST['email']);
                $stmt->bindValue(':password', $_POST['password']);
                $stmt->bindValue(':name', $_POST['name']);
                $stmt->bindValue(':surname', $_POST['surname']);
                $stmt->bindValue(':telephone', $_POST['telephone']);
                $stmt->bindValue(':birth', $_POST['birth']);
                $stmt->bindValue(':cep', $_POST['cep']);
                $stmt->bindValue(':street', $_POST['street']);
                $stmt->bindValue(':numberHouse', $_POST['numberHouse']);
                $stmt->bindValue(':complementHouse', $_POST['complementHouse']);
                $stmt->bindValue(':neighborhood', $_POST['neighborhood']);
                $stmt->bindValue(':city', $_POST['city']);
                $stmt->bindValue(':federativeUnit', $_POST['federativeUnit']);

                $stmt->execute();
                header('Location: ../../pages/login.html');
            }

            break;
        case 'sigin_institution':

            // print_r($_POST);
            
            $query = "SELECT * FROM institution_users WHERE cnpj = :cnpj AND email = :email";

            $stmt = $connection->prepare($query);
            $stmt->bindValue(':cnpj', $_POST['cnpj']);
            $stmt->bindValue(':email', $_POST['email']);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            if(count($result) >= 1) {
                header('Location: ../../pages/signin.html?UsuarioExiste');
            } else {
                $query = "INSERT INTO institution_users(email, password, fantasyName, socialReason, cnpj, telephone, cep, street, numberBuilding, complementBuilding, neighborhood, city, federativeUnit) VALUES ( :email, :password, :fantasyName, :socialReason, :cnpj, :telephone, :cep, :street, :numberBuilding, :complementBuilding, :neighborhood, :city, :federativeUnit)";
        
                $stmt = $connection->prepare($query);
            
                $stmt->bindValue(':email', $_POST['email']);
                $stmt->bindValue(':password', $_POST['password']);
                $stmt->bindValue(':fantasyName', $_POST['name']);
                $stmt->bindValue(':socialReason', $_POST['socialReason']);
                $stmt->bindValue(':cnpj', $_POST['cnpj']);
                $stmt->bindValue(':telephone', $_POST['telephone']);
                $stmt->bindValue(':cep', $_POST['cep']);
                $stmt->bindValue(':street', $_POST['street']);
                $stmt->bindValue(':numberBuilding', $_POST['numberBuilding']);
                $stmt->bindValue(':complementBuilding', $_POST['complementHout']);
                $stmt->bindValue(':neighborhood', $_POST['neighborhood']);
                $stmt->bindValue(':city', $_POST['city']);
                $stmt->bindValue(':federativeUnit', $_POST['federativeUnit']);

                $stmt->execute();
                header('Location: ../../pages/login.html');
            }

            break;
        case 'login':

            $query = "SELECT * FROM person_users WHERE email = :email AND password = :password";
            $stmt = $connection->prepare($query);

            $stmt->bindValue(':email', $_POST['email']);
            $stmt->bindValue(':password', $_POST['password']);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            if(!count($result) >= 1) {
                $query = "SELECT * FROM institution_users WHERE email = :email AND password = :password";
                $stmt = $connection->prepare($query);
    
                $stmt->bindValue(':email', $_POST['email']);
                $stmt->bindValue(':password', $_POST['password']);
    
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            } 
            
            if(count($result) >= 1) {
                $_SESSION['user_id'] = $result[0]->user_id;

                if($result[0]->cnpj) {
                    $_SESSION['user_type'] = 'institution_users';
                    header('Location: ../../pages/dashboardInstitution.php');
                } else {
                    $_SESSION['user_type'] = 'person_users';
                    header('Location: ../../pages/collectionPage.php');
                }
            } else {
                header('Location: ../../pages/login.html?UsuarioInexistente');
            }

            break;
        case 'residue':

                $query = "SELECT * FROM collections WHERE user_id = :userId";
                $stmt = $connection->prepare($query);

                $stmt->bindValue(':userId', $_SESSION['user_id']);

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                if(isset($result[0])) {
                    header('Location: ../../pages/collectionPage.php?CollectionExist');
                } else {
                    // Inserindo os dados da coleta
                    $query = "INSERT INTO collections (user_id, classification, quantity, collection_date, period, additional_information) VALUES (:userId, :classification, :quantity, :collectionDate, :period, :additionalInformation)";

                    $stmt = $connection->prepare($query);

                    $stmt->bindValue(':userId', $_SESSION['user_id']);
                    $stmt->bindValue(':classification', $_POST['residueSelected']);
                    $stmt->bindValue(':quantity', $_POST['quantity']);
                    $stmt->bindValue(':collectionDate', $_POST['collectionDate']);
                    $stmt->bindValue(':period', $_POST['period']);

                    if(isset($_POST['additionalInformation'])) {
                        $stmt->bindValue(':additionalInformation', $_POST['additionalInformation']);
                    } else {
                        $stmt->bindValue(':additionalInformation', null);
                    }

                    $stmt->execute();

                    // Seleciona a coleta solicitada pelo usuário
                    $query = "SELECT * FROM collections WHERE user_id = :userId";
                    $stmt = $connection->prepare($query);

                    $stmt->bindValue(':userId', $_SESSION['user_id']);
                    
                    $stmt->execute();

                    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                    // Atualizando o id da coleta do usuário
                    $query = "UPDATE person_users SET collection_id = :collectionId WHERE user_id = :userId";

                    $stmt = $connection->prepare($query);

                    $stmt->bindValue(':collectionId', $result[0]->collection_id);
                    $stmt->bindValue(':userId', $_SESSION['user_id']);

                    $result = $stmt->execute();

                    header('Location: ../../pages/collectionPage.php');
                }

            break;
        case 'request_collection':

                // Pegar o valor do input recebido por post (que corresponde ao id da empresa)
                $institutionSelected = $_POST['companie'];

                // Pegar o id da coleta criada, a partir do id do usuário logado

                // Na tabela collections, pegar a coleta que possuir o campo "user_id" igual ao do usuário logado

                $query = "SELECT * FROM collections WHERE user_id = :userId";

                $stmt = $connection->prepare($query);

                $stmt->bindValue(':userId', $_SESSION['user_id']);

                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                $collectionCreatedId = $result[0]->collection_id;

                // Adiciona o id da coleta criada, a lista de id's das coletas da empresa

                // A partir do id da empresa selecionada, na tabela "institution_users", pegar a empresa do mesmo id

                $query = "SELECT * FROM institution_users WHERE user_id = :userId";

                $stmt = $connection->prepare($query);

                $stmt->bindValue(':userId', $institutionSelected);

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);


                // Se existir algum id na lista, pegar, transformar em array, adicionar o id da coleta criada e transformar novamente para string


                if(isset($result[0]->collections_id)) {
                    $collectionsId = explode(',', $result[0]->collections_id);
                } else {
                    $collectionsId = [];
                }

                // Adiciona o id da coleta criada ao array
                array_push($collectionsId, $collectionCreatedId);

                // Trannsforma o array em string
                $collectionsId = implode(',', $collectionsId);

                //  Atualiza a lista de id's da empresa selecionada

                $query = "UPDATE institution_users SET collections_id = :newCollectionsId WHERE user_id = :userId";

                $stmt = $connection->prepare($query);

                $stmt->bindValue(':newCollectionsId', $collectionsId);
                $stmt->bindValue(':userId', $institutionSelected);

                $stmt->execute();

                // Atualiza o "stage" da coleta para a de espera (2)
                $query = "UPDATE collections SET stage = :stage WHERE user_id = :userId";

                $stmt = $connection->prepare($query);

                $stmt->bindValue(':stage', 2);
                $stmt->bindValue(':userId', $_SESSION['user_id']);

                $result = $stmt->execute();


                header('Location: ../../pages/collectionPage.php');
            break;
        case 'update_collection_stage-accept':

            $query = "SELECT collections_id_confirmed FROM institution_users WHERE user_id = :userId";
            $stmt = $connection->prepare($query);

            $stmt->bindValue(':userId', $_SESSION['user_id']);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ)[0]->collections_id_confirmed;

            if($result) {
                $allCollections_data_confirmed = explode(',', $result);
            } else {
                $allCollections_data_confirmed = [];
            }

            echo "Todas as coletas já confirmadas: ";
            print_r($allCollections_data_confirmed);

            foreach ($_POST as $key => $value) {
                array_push($allCollections_data_confirmed, $key);
            }

            echo "<br>";

            echo "Todas as coletas já confirmadas (após inserir a selecionada para confirmar): ";
            print_r($allCollections_data_confirmed);


            $query = "SELECT collections_id FROM institution_users WHERE user_id = :userId";
            $stmt = $connection->prepare($query);

            $stmt->bindValue(':userId', $_SESSION['user_id']);

            $stmt->execute();
            $result = explode(',', $stmt->fetchAll(PDO::FETCH_OBJ)[0]->collections_id);

            foreach ($result as $chave => $valor) {
                if(isset($_POST[$valor])) {
                    unset($result[array_search($valor, $result)]);
                }
            }
            
            $query = "UPDATE institution_users SET collections_id = :collectionsId WHERE user_id = :userId";
            $stmt = $connection->prepare($query);

            if(implode(',', $result)) {
                $stmt->bindValue(':collectionsId', implode(',', $result));
            } else {
                $stmt->bindValue(':collectionsId', null);
            }
            $stmt->bindValue(':userId', $_SESSION['user_id']);

            $stmt->execute();
            
            echo "<br>";

            echo implode(',', $result);



            $query = "UPDATE institution_users SET collections_id_confirmed = :collectionsConfirmed WHERE user_id = :userId";
            $stmt = $connection->prepare($query);

            $stmt->bindValue(':collectionsConfirmed', implode(',', $allCollections_data_confirmed));
            $stmt->bindValue(':userId', $_SESSION['user_id']);

            $stmt->execute();

            // zerar
            // $_SESSION['collectionsConfirmed'] = '';


            header('Location: ../../pages/dashboardInstitution.php');
            break;
        case 'update_collection_stage-refuse':

            $collectionsCanceled =  [];

            foreach ($_POST as $key => $value) {

                array_push($collectionsCanceled, $key);

                $query = "UPDATE collections SET stage = 0 WHERE collection_id = :collectionId";
                $stmt = $connection->prepare($query);

                $stmt->bindValue(':collectionId', $key);

                $stmt->execute();



                $query = "SELECT collections_id FROM institution_users WHERE user_id = :userId";
                $stmt = $connection->prepare($query);

                $stmt->bindValue(':userId', $_SESSION['user_id']);

                $stmt->execute();
                $result = explode(',', $stmt->fetchAll(PDO::FETCH_OBJ)[0]->collections_id);

                foreach ($result as $chave => $valor) {
                    if($valor == $key) {
                        unset($result[array_search($valor, $result)]);
                    }
                }
                
                $query = "UPDATE institution_users SET collections_id = :collectionsId WHERE user_id = :userId";
                $stmt = $connection->prepare($query);

                if(implode(',', $result)) {
                    $stmt->bindValue(':collectionsId', implode(',', $result));
                } else {
                    $stmt->bindValue(':collectionsId', null);
                }
                $stmt->bindValue(':userId', $_SESSION['user_id']);

                $stmt->execute();
            }

            // $collectionsCanceled = implode(',', $collectionsCanceled);
            // echo $collectionsCanceled;

            header('Location: ../../pages/dashboardInstitution.php');
            break;
        case 'update_person_users':

            $query = "UPDATE person_users SET email = :email, password = :password, name = :name, surname = :surname, telephone = :telephone, birth = :birth, cep = :cep, street = :street, numberHouse = :numberHouse, complementHouse = :complementHouse, neighborhood = :neighborhood, city = :city, federativeUnit = :federativeUnit, photo_path = :userPhoto WHERE user_id = :userId";

            $stmt = $connection->prepare($query);

            $stmt->bindValue(':email', $_POST['email']);
            $stmt->bindValue(':password', $_POST['password']);
            $stmt->bindValue(':name', $_POST['name']);
            $stmt->bindValue(':surname', $_POST['surname']);
            $stmt->bindValue(':telephone', $_POST['telephone']);
            $stmt->bindValue(':birth', $_POST['birth']);
            $stmt->bindValue(':cep', $_POST['cep']);
            $stmt->bindValue(':street', $_POST['street']);
            $stmt->bindValue(':numberHouse', $_POST['numberHouse']);

            if($_POST['complementHouse'] != "") {
                $stmt->bindValue(':complementHouse', $_POST['complementHouse']);
            } else {
                $stmt->bindValue(':complementHouse', null);
            }
            
            $stmt->bindValue(':neighborhood', $_POST['neighborhood']);
            $stmt->bindValue(':city', $_POST['city']);
            $stmt->bindValue(':federativeUnit', $_POST['federativeUnit']);

            if($_POST['userPhoto'] != "") {
                $stmt->bindValue(':userPhoto', $_POST['userPhoto']);
            } else {
                $stmt->bindValue(':userPhoto', null);
            }

            $stmt->bindValue(':userId', $_SESSION['user_id']);

            try {
                $result = $stmt->execute();
            } catch(PDOException $e) {
                echo "<pre>";
                echo $e;
                echo "</pre>";
            }

            header('Location: ../../pages/profile.php');

            break;
        case 'update_institution_users':

            $query = "UPDATE institution_users SET email = :email, password = :password, fantasyName = :fantasyName, socialReason = :socialReason, cnpj = :cnpj, telephone = :telephone, cep = :cep, street = :street, numberBuilding = :numberBuilding, complementBuilding = :complementBuilding, neighborhood = :neighborhood, city = :city, federativeUnit = :federativeUnit, about = :about, photo_path = :userPhoto WHERE user_id = :userId";

            $stmt = $connection->prepare($query);

            $stmt->bindValue(':email', $_POST['email']);
            $stmt->bindValue(':password', $_POST['password']);
            $stmt->bindValue(':fantasyName', $_POST['name']);
            $stmt->bindValue(':socialReason', $_POST['socialReason']);
            $stmt->bindValue(':cnpj', $_POST['cnpj']);
            $stmt->bindValue(':telephone', $_POST['telephone']);
            $stmt->bindValue(':cep', $_POST['cep']);
            $stmt->bindValue(':street', $_POST['street']);
            $stmt->bindValue(':numberBuilding', $_POST['numberBuilding']);

            if($_POST['complementBuilding'] != "") {
                $stmt->bindValue(':complementBuilding', $_POST['complementBuilding']);
            } else {
                $stmt->bindValue(':complementBuilding', null);
            }

            $stmt->bindValue(':neighborhood', $_POST['neighborhood']);
            $stmt->bindValue(':city', $_POST['city']);
            $stmt->bindValue(':federativeUnit', $_POST['federativeUnit']);

            if($_POST['userPhoto'] != "") {
                $stmt->bindValue(':userPhoto', $_POST['userPhoto']);
            } else {
                $stmt->bindValue(':userPhoto', null);
            }

            if($_POST['about'] != "") {
                $stmt->bindValue(':about', $_POST['about']);
            } else {
                $stmt->bindValue(':about', null);
            }

            $stmt->bindValue(':userId', $_SESSION['user_id']);

            try {
                $result = $stmt->execute();
            } catch(PDOException $e) {
                echo "<pre>";
                echo $e;
                echo "</pre>";
            }

            header('Location: ../../pages/profile.php');

            break;
        
        case "collection-alter":

            foreach($_POST as $key => $value) {
                $_SESSION['collection_id_focus'] = $key;
            }

            header('Location: ../../pages/dashboardInstitution.php');
            break;
        case "collection-end":

            foreach ($_POST as $key => $value) {

                // Seleciona o usuário que criou a coleta a ser finalizada e atualiza o campo "collection_id" dele
                $query = "UPDATE person_users SET collection_id = :collectionFinished WHERE collection_id = :collectionId";

                $stmt = $connection->prepare($query);

                $stmt->bindValue(':collectionId', strval($key));
                $stmt->bindValue(':collectionFinished', null);
                
                $result = $stmt->execute();

                // Pega o campo "collections_id_confirmed" da empresa
                $query = "SELECT collections_id_confirmed FROM institution_users WHERE user_id = :userId";
                $stmt = $connection->prepare($query);

                $stmt->bindValue(':userId', $_SESSION['user_id']);

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);


                $allCollectionsConfirmed = explode(',', $result[0]->collections_id_confirmed);

                foreach ($allCollectionsConfirmed as $index => $id) {
                    if($id == $key) {
                        unset($allCollectionsConfirmed[array_search($id, $allCollectionsConfirmed)]);
                    }
                }

                // Após retirar o id da coleta a ser excluída, do array, tornamos o array uma string novamente
                $allCollectionsConfirmed = implode(',', $allCollectionsConfirmed);

                // Atualiza o campo "collections_id_confirmed" da empresa
                $query = "UPDATE institution_users SET collections_id_confirmed = :collectionsConfirmed WHERE user_id = :userId";
                $stmt = $connection->prepare($query);

                if(!empty($allCollectionsConfirmed)) {
                    $stmt->bindValue(':collectionsConfirmed', $allCollectionsConfirmed);
                } else {
                    $stmt->bindValue(':collectionsConfirmed', null);
                }
                
                $stmt->bindValue(':userId', $_SESSION['user_id']);

                $stmt->execute();



                $query = "SELECT concludedCollections FROM institution_users WHERE user_id = :userId";
                $stmt = $connection->prepare($query);

                $stmt->bindValue(':userId', $_SESSION['user_id']);
                $stmt->execute();
                $rating = $stmt->fetchAll(PDO::FETCH_OBJ)[0]->concludedCollections;

                $query = "UPDATE institution_users SET concludedCollections = :concludedCollections WHERE user_id = :userId";
                $stmt = $connection->prepare($query);

                if(!empty($rating)) {
                    $stmt->bindValue(':concludedCollections', $rating += 1);
                } else {
                    $stmt->bindValue(':concludedCollections', 1);
                }
                
                $stmt->bindValue(':userId', $_SESSION['user_id']);

                $stmt->execute();   

                // Apaga a coleta
                $query = "DELETE FROM collections WHERE collection_id = :collectionId";
                $stmt = $connection->prepare($query);

                $stmt->bindValue(':collectionId', $key);
                
                $stmt->execute();

                if($_SESSION['collection_id_focus'] == $key) {
                    $_SESSION['collection_id_focus'] = null;
                }
            }

            header('Location: ../../pages/dashboardInstitution.php');

            break;
        case 'registerRequest':

            try {
                $query = "SELECT * FROM person_users WHERE email = :email";

                $stmt = $connection->prepare($query);
                $stmt->bindValue(':email', $_POST['email']);
    
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                if(isset($result[0]) && $result[0]->collection_id != null) {
                    header('Location: ../../pages/include.html?Usuario&SolicitacaoExistem');
                }
                
                if(empty($result[0])) {
                    $query = "INSERT INTO person_users(email, name, surname, telephone, birth, cep, street, numberHouse, complementHouse, neighborhood, city, federativeUnit) VALUES (:email, :name, :surname, :telephone, :birth, :cep, :street, :numberHouse, :complementHouse, :neighborhood, :city, :federativeUnit)";
            
                    $stmt = $connection->prepare($query);
    
                    $stmt->bindValue(':email', $_POST['email']);
                    $stmt->bindValue(':name', $_POST['name']);
                    $stmt->bindValue(':surname', $_POST['surname']);
                    $stmt->bindValue(':telephone', $_POST['telephone']);
                    $stmt->bindValue(':birth', $_POST['birth']);
                    $stmt->bindValue(':cep', $_POST['cep']);
                    $stmt->bindValue(':street', $_POST['street']);
                    $stmt->bindValue(':numberHouse', $_POST['numberHouse']);
                    $stmt->bindValue(':complementHouse', $_POST['complementHouse']);
                    $stmt->bindValue(':neighborhood', $_POST['neighborhood']);
                    $stmt->bindValue(':city', $_POST['city']);
                    $stmt->bindValue(':federativeUnit', $_POST['federativeUnit']);
    
                    $stmt->execute();
                }
                
                if(isset($result[0]) && $result[0]->collection_id == null) {

                    $query = "SELECT * FROM person_users WHERE email = :email";
                    $stmt = $connection->prepare($query);
        
                    $stmt->bindValue(':email', $_POST['email']);

                    $stmt->execute();

                    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                    $userCreatedId = $result[0]->user_id;
        
                    // Cria o registro de uma nova coleta (passando o id único como usuário que criou)
                    $query = "INSERT INTO collections (user_id, stage, classification, quantity, collection_date, period, additional_information) VALUES (:userId, :stage, :classification, :quantity, :collectionDate, :period, :additionalInformation)";
        
                    $stmt = $connection->prepare($query);
        
                    $stmt->bindValue(':userId', $userCreatedId);
                    $stmt->bindValue(':stage', 1);
                    $stmt->bindValue(':classification', $_POST['residueSelected']);
                    $stmt->bindValue(':quantity', $_POST['quantity']);
                    $stmt->bindValue(':collectionDate', $_POST['collectionDate']);
                    $stmt->bindValue(':period', $_POST['period']);
        
                    if(isset($_POST['additionalInformation'])) {
                        $stmt->bindValue(':additionalInformation', $_POST['additionalInformation']);
                    } else {
                        $stmt->bindValue(':additionalInformation', null);
                    }
        
                    $stmt->execute();
        
                    // Seleciona a empresa logada 
                    $query = "SELECT * FROM institution_users WHERE user_id = :userId";
                    $stmt = $connection->prepare($query);
        
                    $stmt->bindValue(':userId', $_SESSION['user_id']);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        
                    if(!empty($result[0]->collections_id)) {
                        $collectionsList_id = explode(",", $result[0]->collections_id);
                    } else {
                        $collectionsList_id = [];
                    }

        
                    // Seleciona todas as coletas que tiverem o campo "user_id" igual ao id do usuário criado
                    $query = "SELECT * FROM collections WHERE user_id = :userId";
                    $stmt = $connection->prepare($query);
        
                    $stmt->bindValue(':userId', $userCreatedId);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        
                    // Pega os ids das coletas não confirmadas da empresa logada e adiciona o id da solicitação criada (id do usuário criado)
                    array_push($collectionsList_id, $result[0]->collection_id);
                    $collectionsList_id = implode(',', $collectionsList_id);
        
                    // Atualiza o campo das coletas não confirmadas 

                    $query = "UPDATE institution_users SET collections_id = :collectionsId WHERE user_id = :userId";
                    $stmt = $connection->prepare($query);
        
                    $stmt->bindValue(':userId', $_SESSION['user_id']);
                    $stmt->bindValue(':collectionsId', $collectionsList_id);
                    $stmt->execute();

                    // Atualiza o campo id da coleta no usuário criado
                    $query = "UPDATE person_users SET collection_id = :collectionId WHERE user_id = :userId";
                    $stmt = $connection->prepare($query);
        
                    $stmt->bindValue(':userId', $userCreatedId);
                    $stmt->bindValue(':collectionId', $result[0]->collection_id);
                    $stmt->execute();

                    header('Location: ../../pages/include.html?Success');
                }

                header('Location: ../../pages/include.html?Success');
    
            }catch(PDOException $e) {
                echo "<pre>";
                print_r($e);
                echo "</pre>";
            }

            break;
        case 'exit':
                session_destroy();
                header('Location: ../../pages/login.html');
            break;
        default:
            echo 'algo deu errado';

            echo "<pre>";
            print_r($_POST);
            echo "</pre>";

            echo "<br>";

            echo "<pre>";
            print_r($_GET);
            echo "</pre>";

        break;
    }
?>