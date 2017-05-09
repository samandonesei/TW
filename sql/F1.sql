set serveroutput on;

-- locatia favorita pt fiecare detinator
CREATE OR REPLACE PROCEDURE locatie1 (emp_cursor OUT SYS_REFCURSOR)
AS
v_id_locatie integer;
v_nr_locatii integer;
locatie_inexistenta EXCEPTION;
  PRAGMA EXCEPTION_INIT(locatie_inexistenta, -20001);
CURSOR locatii( idDetinator integer) IS (select id_locatie,  COUNT(id_locatie) from Artefact where idDetinator = id_detinator GROUP BY id_locatie);

BEGIN
/*
FOR i in (select id, nume, tip from DETINATOR)
LOOP
  v_max_locatii := 0;
  v_id_max := -1;
    
    OPEN locatii(i.id);
    LOOP
    FETCH locatii into v_id_locatie, v_nr_locatii;
    EXIT WHEN locatii%NOTFOUND;
    
        --dbms_output.put_line (v_nr_locatii);
    IF v_nr_locatii > v_max_locatii 
      THEN
      v_max_locatii := v_nr_locatii;
      v_id_max := v_id_locatie;
    END IF;
    END LOOP;
    
    OPEN emp_cursor FOR
    SELECT i.nume || ' are locatie favorita: ' || oras || ' - ' || nume_sit from locatie WHERE id = v_id_max;
    
    --dbms_output.put_line (i.nume || ' ' || v_oras_favorit);
    
    CLOSE locatii;
END LOOP;
*/
v_nr_locatii := 0;
FOR i in (select id, nume, tip from DETINATOR)
LOOP
  OPEN locatii(i.id);
  LOOP
    FETCH locatii into v_id_locatie, v_nr_locatii;
    EXIT WHEN locatii%NOTFOUND;
  END LOOP;
    IF (v_nr_locatii = 0) THEN RAISE locatie_inexistenta;
    END IF;
  CLOSE locatii;
END LOOP;
OPEN emp_cursor FOR
SELECT d.nume || ' are locatie favorita: ' || l.oras || ' - ' || l.nume_sit  FROM detinator d JOIN artefact a ON d.id = a.id_detinator
          JOIN locatie l ON l.id = a.id_locatie GROUP BY l.id,l.nume_sit, l.oras, d.nume
         HAVING COUNT(l.id) = (SELECT MAX(COUNT(id_locatie)) FROM artefact WHERE id_locatie = l.id GROUP BY id_locatie);

EXCEPTION
    WHEN locatie_inexistenta THEN
     OPEN emp_cursor FOR SELECT 'S-a gasit un artefact fara locatie' FROM dual;
    WHEN NO_DATA_FOUND THEN
      open emp_cursor for select 'No data found in DB' from dual;

END locatie1;
/

  
-- DROP PROCEDURE locatie1
/* 
set serveroutput on; 
variable usercur refcursor;
BEGIN
locatie1(:usercur);
END;
/
print usercur
*/
    

  
  