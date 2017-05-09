set serveroutput on;
/*
5.Distributia Artefactelor in functie de tipologie, se considera un artefact 
drept Generic, daca aparatine mai mult de 2 tipologii
*/
CREATE OR REPLACE FUNCTION tip_artefact( idArtefact integer)
return varchar
AS
tip varchar(20);

BEGIN

SELECT CASE
WHEN EXISTS (SELECT a.id
                  FROM tipologie t JOIN incadrare inc ON inc.id_tipologie = t.id
                  JOIN artefact a ON a.id = inc.id_artefact
                  WHERE idArtefact = id_artefact
                  GROUP BY a.id
                  HAVING count(inc.id_artefact) > 1
                  )
THEN 'Generic'

WHEN EXISTS (SELECT a.id
                  FROM tipologie t JOIN incadrare inc ON inc.id_tipologie = t.id
                  JOIN artefact a ON a.id = inc.id_artefact
                  WHERE idArtefact = id_artefact
                  GROUP BY a.id
                  HAVING count(inc.id_artefact) = 1
                  )
THEN 'Regular'

ELSE
    'Unic'
END 
INTO tip
FROM DUAL;

return tip;
END tip_artefact;
/

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

OPEN emp_cursor FOR
SELECT 'Fara tipologie ' || a.nume || ' tip artefact: Unic'
             FROM  artefact a WHERE tip_artefact(a.id) = 'Unic'
UNION
SELECT t.nume || ' - artefact: ' || a.nume || ' tip artefact: ' || tip_artefact(a.id)
            FROM tipologie t JOIN incadrare inc ON inc.id_tipologie = t.id
            JOIN artefact a ON a.id = inc.id_artefact
            GROUP BY a.nume, a.id, t.nume, t.id;

 /*

OPEN emp_cursor FOR
SELECT 'Nr. artefacte unice = ' || count(a.id)  FROM artefact a WHERE NOT EXISTS ( SELECT * FROM incadrare WHERE id_artefact = a.id);
UNION ALL
SELECT 'Nr. artefacte regulare = ' || count(id) FROM artefact WHERE id IN
                          (SELECT a.id
                          FROM tipologie t JOIN incadrare inc ON inc.id_tipologie = t.id
                          JOIN artefact a ON a.id = inc.id_artefact
                          GROUP BY a.id
                          HAVING count(inc.id_artefact) = 1
                          );
OPEN emp_cursor FOR
SELECT 'Nr. artefacte generice = ' || count(id) FROM artefact WHERE id IN
                          (SELECT a.id
                          FROM tipologie t JOIN incadrare inc ON inc.id_tipologie = t.id
                          JOIN artefact a ON a.id = inc.id_artefact
                          GROUP BY a.id
                          HAVING count(inc.id_artefact) > 1
                          );
*/
EXCEPTION
  when NO_DATA_FOUND then
    OPEN emp_cursor FOR
      select 'no data found ' from dual;
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
-- select count(id) from artefact where nume like '%Katana lui John Locke%';