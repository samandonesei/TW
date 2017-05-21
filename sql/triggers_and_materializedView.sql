set define off;
CREATE OR REPLACE TRIGGER artefact_remove_arheolog -- FOREIGN KEY (ID_Arheolog) 
BEFORE DELETE ON arheolog
FOR EACH ROW
BEGIN
  UPDATE artefact a SET a.id_arheolog = 0 WHERE a.id_arheolog = :old.id;
END;
/   

set define off;
CREATE OR REPLACE TRIGGER artefact_remove_detinator 
BEFORE DELETE ON detinator
FOR EACH ROW
BEGIN
  UPDATE artefact a SET a.id_detinator = 0 WHERE a.id_detinator = :old.id;
END;
/ 

set define off;
CREATE OR REPLACE TRIGGER artefact_remove_locatie 
BEFORE DELETE ON locatie
FOR EACH ROW
BEGIN
  UPDATE artefact a SET a.id_locatie = 0 WHERE a.id_locatie = :old.id;
END;
/ 

-- soft delete
CREATE TABLE deleted_locatie as SELECT * FROM locatie WHERE 1=2;
CREATE OR REPLACE TRIGGER arheolog_remove_locatie
BEFORE DELETE ON locatie
FOR EACH ROW 
BEGIN
  INSERT INTO deleted_locatie VALUES(:old.ID, :old.Nume_Sit, :old.Continent, :old.Tara, :old.Oras); 
  UPDATE arheolog a SET a.id_locatie = 0 WHERE a.id_locatie = :old.id;
END;
/

set define off;
CREATE OR REPLACE TRIGGER caracteristici_remove_artefact
BEFORE DELETE ON artefact
FOR EACH ROW
BEGIN
  UPDATE caracteristici c SET c.id_artefact = 0 WHERE c.id_artefact = :old.id;
END;
/ 

set define off;
CREATE OR REPLACE TRIGGER incadrare_remove_artefact
BEFORE DELETE ON artefact
FOR EACH ROW
BEGIN
  UPDATE incadrare i SET i.id_artefact = 0 WHERE i.id_artefact = :old.id;
END;
/ 

--ALTER TABLE Artefact DROP CONSTRAINT fk_Artefact_Arheolog;
--ALTER TABLE Artefact DROP CONSTRAINT fk_Artefact_Detinator;
--ALTER TABLE Artefact DROP CONSTRAINT fk_Artefact_Locatie;
--ALTER TABLE Artefact DROP CONSTRAINT fk_Incadrare_Artefact;
--ALTER TABLE Artefact DROP CONSTRAINT fk_Caracteristici_Artefact;
--ALTER TABLE Artefact DROP CONSTRAINT fk_Arheolog_Locatie;
-- delete from arheolog where id <50;
-- select * from artefact where id_arheolog = 0;

CREATE OR REPLACE FUNCTION is_number (p_string IN VARCHAR2)
   RETURN INT
IS
   v_new_num NUMBER;
BEGIN
   v_new_num := TO_NUMBER(p_string);
   RETURN 1;
EXCEPTION
WHEN VALUE_ERROR THEN
   RETURN 0;
END is_number;

-- materialized view -> gruparea artefactelor ce valoreaza minim 1B in functie de material si nr detinatori
CREATE MATERIALIZED VIEW value_by_material
     --TABLESPACE TW
     PARALLEL 4
     BUILD IMMEDIATE
     REFRESH COMPLETE
     --ENABLE QUERY REWRITE
     AS SELECT c.material, SUM(CAST(substr(valoare_est,1,length(valoare_est)-1) AS int)) AS valoare_material, COUNT(d.id) as nr_owners 
        FROM artefact a, detinator d, caracteristici c
        WHERE a.id_detinator = d.id AND a.id = c.id_artefact AND is_number(substr(valoare_est,1,length(valoare_est)-1)) = 1
        AND substr(c.valoare_est,length(c.valoare_est)) = 'B'
        GROUP BY c.material ORDER BY 2 DESC;

-- select * from value_by_material;