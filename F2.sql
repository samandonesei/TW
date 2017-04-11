set serveroutput on;
/*
5.Distributia Artefactelor in functie de tipologie, se considera un artefact 
drept Generic, daca aparatine mai mult de 2 tipologii
*/

CREATE OR REPLACE PROCEDURE distr_artefacte (emp_cursor OUT SYS_REFCURSOR)
AS
v_nr_artefacte integer;
v_nr_tipologii integer;
v_id_artefact integer;
v_generic integer;
v_nume_artefact artefact.nume%type;
CURSOR tipologii( idTipologie integer) IS (select id_artefact from Incadrare 
                                              where idTipologie = id_tipologie);

BEGIN

FOR i in (select id, nume FROM tipologie)
LOOP
  dbms_output.put_line(i.nume );
  dbms_output.put_line('');
  dbms_output.put_line('');
  v_nr_tipologii := 0;
  v_generic := 0;
  v_nr_artefacte := 0;
  OPEN tipologii(i.id);
    LOOP
      FETCH tipologii into v_id_artefact;
      EXIT WHEN tipologii%NOTFOUND;
      v_nr_artefacte := v_nr_artefacte + 1;
      SELECT COUNT(id_tipologie) INTO v_nr_tipologii from Incadrare where v_id_artefact = id_artefact; -- GROUP BY id_tipologie;
      SELECT nume INTO v_nume_artefact FROM artefact WHERE v_id_artefact = id;

      IF v_nr_tipologii > 1
        THEN
        dbms_output.put_line(v_nume_artefact || ' - generic' );
        ELSIF v_nr_tipologii = 1
        THEN
        dbms_output.put_line(v_nume_artefact || ' - regular' );
        ELSE
        dbms_output.put_line(v_nume_artefact || ' - unic' );
        END IF;
    END LOOP;
    dbms_output.put_line('');
    dbms_output.put_line(i.nume || ' contine ' || v_nr_artefacte || ' artefacte.');
  CLOSE tipologii;
END LOOP;
END distr_artefacte;
/

-- DROP PROCEDURE distr_artefacte
/* 
set serveroutput on; 
variable usercur refcursor;
BEGIN
distr_artefacte(:usercur);
END;
/
*/
