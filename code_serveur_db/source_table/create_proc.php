<?php
# Deletion of tables
# Group 1 : M.L. and F.C.

# Login connexion
include '../../../utils/connexion.php';

try {
    // connexion to the database
    $conn = new PDO("mysql:host=localhost;dbname=DBIndex", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

	// requete creation proc
	
	$query = "DROP PROCEDURE IF EXISTS PENTITY;
		CREATE PROCEDURE PENTITY (IN VENTITY VARCHAR(50)) BEGIN INSERT INTO entity(id_entity,type_entity) VALUES (NULL,VENTITY);END;

		DROP PROCEDURE IF EXISTS PARTICLE;
        CREATE PROCEDURE PARTICLE (IN VDATE_PUBLICATION DATE, IN VRATE_POSITIVITY FLOAT,
		IN VRATE_NEGATIVITY FLOAT, IN VRATE_JOY FLOAT, IN VRATE_FEAR FLOAT, IN VRATE_SADNESS FLOAT,
		IN VRATE_ANGRY FLOAT, IN VRATE_SURPRISE FLOAT, IN VRATE_DISGUST FLOAT, IN VID_NEWSPAPER INT, OUT VID_ARTICLE INT)
		BEGIN
		INSERT INTO article (id_article, date_publication, rate_positivity, rate_negativity, rate_joy, 
		rate_fear, rate_sadness, rate_angry, rate_surprise, rate_disgust, id_newspaper) 
		VALUES (NULL,VDATE_PUBLICATION,VRATE_POSITIVITY,VRATE_NEGATIVITY,VRATE_JOY,VRATE_FEAR,
		VRATE_SADNESS,VRATE_ANGRY,VRATE_SURPRISE,VRATE_DISGUST,VID_NEWSPAPER);
		END;
		
		DROP PROCEDURE IF EXISTS PPOS_TAGGING;
		CREATE PROCEDURE PPOS_TAGGING (IN VPOS_TAG VARCHAR(25))   
		BEGIN
		INSERT INTO pos_tagging (id_pos_tag, pos_tag) VALUES (NULL,VPOS_TAG);
		END;
		
		DROP PROCEDURE IF EXISTS PBELONG;
		CREATE PROCEDURE PBELONG (IN VID_ARTICLE INT, IN VID_LABEL INT)   
		BEGIN
 		INSERT INTO belong (id_article,id_label) VALUES (VID_ARTICLE ,VID_LABEL);
		END;
		
		DROP PROCEDURE IF EXISTS PAUTHOR;
		CREATE PROCEDURE PAUTHOR (IN VSURNAME_AUTHOR VARCHAR(50), IN VFIRSTNAME_AUTHOR VARCHAR(50), OUT VID_AUTHOR INT)   
		BEGIN
 		INSERT INTO author (ID_AUTHOR, SURNAME_AUTHOR, FIRSTNAME_AUTHOR) VALUES (NULL, VSURNAME_AUTHOR,VFIRSTNAME_AUTHOR);
 		SELECT LAST_INSERT_ID() INTO VID_AUTHOR;
		END;
		
		DROP PROCEDURE IF EXISTS PNEWSPAPER;
		CREATE PROCEDURE PNEWSPAPER (IN VNAME_NEWSPAPER VARCHAR(50),IN VLINK_NEWSPAPER VARCHAR(2083),IN VLINK_LOGO VARCHAR(2083))
		BEGIN
	    INSERT INTO newspaper(id_newspaper,name_newspaper,link_newspaper,link_logo) VALUES (NULL,VNAME_NEWSPAPER,VLINK_NEWSPAPER,VLINK_LOGO);
		END;
		
		DROP PROCEDURE IF EXISTS PLABEL;
		CREATE PROCEDURE PLABEL (IN VLABEL VARCHAR(50))
		BEGIN
  	    INSERT INTO label (id_label,label) VALUES (NULL,VLABEL);
		END;
		
		DROP PROCEDURE IF EXISTS PPOSITION_WORD;
		CREATE PROCEDURE PPOSITION_WORD (IN VPOSITION INT, IN VTITLE BOOLEAN, IN VWORD VARCHAR(50), VTYPE_ENTITY VARCHAR(25), IN VPOS_TAG VARCHAR(25), IN VID_ARTICLE INT,IN VFILE_WIKI VARCHAR(255))   
		BEGIN
		DECLARE VID_WORD INT;
     	DECLARE VID_ENTITY INT; 
     	DECLARE VID_POS_TAG INT;
     	DECLARE VID_WIKI INT;
     
     	SELECT ID_WORD INTO VID_WORD
     	FROM word
     	WHERE WORD = VWORD;
     
     	SELECT ID_ENTITY INTO VID_ENTITY
     	FROM entity
     	WHERE TYPE_ENTITY = VTYPE_ENTITY;
     
    	SELECT ID_POS_TAG INTO VID_POS_TAG
     	FROM pos_tagging
     	WHERE POS_TAG = VPOS_TAG;
     
     	SELECT ID_WIKI INTO VID_WIKI
     	FROM wiki
     	WHERE FILE_WIKI = VFILE_WIKI;

     	INSERT INTO position_word (ID_POSITION, POSITION,TITLE,ID_WORD,ID_ENTITY,ID_POS_TAG,ID_ARTICLE,ID_WIKI) 
     	VALUES (NULL, VPOSITION,VTITLE,VID_WORD,VID_ENTITY,VID_POS_TAG,VID_ARTICLE,VID_WIKI);
		END;


		DROP PROCEDURE IF EXISTS PSYNONYM;
		CREATE PROCEDURE PSYNONYM (IN VSYNONYM VARCHAR(50), IN VWORD VARCHAR(50))   
		BEGIN
		DECLARE VID_SYNONYM INT DEFAULT 0;

		INSERT INTO synonym (ID_SYNONYM, SYNONYM) VALUES (NULL,VSYNONYM);
    	SELECT LAST_INSERT_ID() INTO VID_SYNONYM;

    	UPDATE WORD
		SET WORD.ID_SYNONYM = VID_SYNONYM
		WHERE WORD.WORD = VWORD;
		END;

		DROP PROCEDURE IF EXISTS PWIKI;
		CREATE PROCEDURE PWIKI (IN VFILE_WIKI VARCHAR(500), OUT VID_WIKI INT)   
		BEGIN
	    INSERT INTO wiki (ID_WIKI, FILE_WIKI) VALUES (NULL, VFILE_WIKI);
     	SELECT LAST_INSERT_ID() INTO VID_WIKI;
		END;


		DROP PROCEDURE IF EXISTS PWORD;
		CREATE PROCEDURE PWORD (IN VWORD VARCHAR(50), IN VLEMMA VARCHAR(50), OUT VID_WORD INT)
		BEGIN
		DECLARE VID_LEMMA INT DEFAULT 0;
		DECLARE VID_SYNONYM INT DEFAULT 0 ;

    	INSERT INTO lemma (id_lemma,lemma) VALUES (NULL,VLEMMA);  
    	SELECT LAST_INSERT_ID() INTO VID_LEMMA;
	
    	INSERT INTO word (id_word,word,id_lemma,id_synonym) VALUES (NULL, VWORD, VID_LEMMA, NULL);
    	SELECT LAST_INSERT_ID() INTO VID_WORD;
		END;";
		

 	$data = $conn->query($query);
 	
    //view the entire array (for testing)
    //print_r($result);*/
    
    }
catch(PDOException $e)
    {
    echo  $e->getMessage();
    }
$conn = null;

?>
