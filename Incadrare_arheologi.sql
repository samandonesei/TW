create or replace package distributie_arheologi is 
  function grad_arheolog(p_id in arheolog.id%type) return varchar2;
  function numar(p_string varchar2) return pls_integer;
  procedure distribuire (p_curs out sys_refcursor);
end distributie_arheologi;

create or replace package body distributie_arheologi is
 function nr_descoperiri(p_id in arheolog.id%type) return pls_integer is
  v_int pls_integer;
  begin 
    select count(*) into v_int from arheolog a join artefact l on a.id=l.id_arheolog where a.id=p_id;
    return v_int;
  end nr_descoperiri;

 function grad_arheolog(p_id in arheolog.id%type) return varchar2 is
  v_string varchar2(255);
  v_int pls_integer;
  begin
    v_int:=nr_descoperiri(p_id);
    if v_int=0 then v_string:='Begginers';
    elsif v_int =1 or v_int=2 then v_string:='Novices';
    elsif v_int=3 or v_int=4 then v_string:='Professionals';
    else v_string:='Experts';
    end if;
    return v_string;
  end grad_arheolog;

 function numar (p_string varchar2) return pls_integer is
    v_int pls_integer;
  begin
    select count(*) into v_int from arheolog where grad_arheolog(id)=p_string;
    return v_int;
  end numar;

 procedure distribuire(p_curs out sys_refcursor) is
    v_total pls_integer;
    empty_table EXCEPTION;
    pragma exception_init(empty_table,-20001);
  begin
    select count(*) into v_total from arheolog;
    if v_total=0 then
      raise empty_table;
    else
    open p_curs for 
      select grad_arheolog(id),numar(grad_arheolog(id)),trunc((numar(grad_arheolog(id))*100)/v_total,2)||'%' from arheolog group by grad_arheolog(id);
    end if;
  exception
    when empty_table then
      open p_curs for
        select 'Va rugam contactati un admin,una dintre tabele a fost golita!' from dual;
  end distribuire;
end distributie_arheologi;


--drop package distributie_arheologi;


/*set serveroutput on;
declare 
  l_cursor sys_refcursor;
  l_inc varchar2(255);
  l_int pls_integer;
  l_proc varchar2(255);
begin
  distributie_arheologi.distribuire(p_curs=>l_cursor);
  loop
    fetch l_cursor
    into l_inc,l_int,l_proc;
    exit when l_cursor%notfound;
    dbms_output.put_line(l_inc||' '||l_int||' '||l_proc);
  end loop;
  close l_cursor;
end;
*/
