set serveroutput on;

-- locatia favorita pt fiecare detinator
CREATE OR REPLACE PROCEDURE locatie1 (emp_cursor OUT SYS_REFCURSOR)
AS
v_nr_artefacte integer;
v_oras_favorit varchar2(300);
v_id_locatie integer;
v_id_max integer;
v_max_locatii integer;
v_nr_locatii integer;
CURSOR locatii( idDetinator integer) IS (select id_locatie,  COUNT(id_locatie) from Artefact where idDetinator = id_detinator GROUP BY id_locatie);

BEGIN
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
    
    select 'are locatie favorita: ' || oras || ' - ' || nume_sit into v_oras_favorit from locatie WHERE id = v_id_max;
    dbms_output.put_line (i.nume || ' ' || v_oras_favorit);
    
    CLOSE locatii;
END LOOP;
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
    

  
  