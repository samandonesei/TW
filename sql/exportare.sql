declare
  v_owner varchar2(255):='STUDENT';
  v_inutil number;
  v_countt pls_integer;
  v_tip varchar2(255):='TABLE';
  v_tipcoloana dbms_sql.desc_tab;
  v_count number;
  v_execute varchar2(1000);
  v_cursor number;
  v_numar number;
  v_data date;
  v_timestamp varchar2(255);
  v_string varchar2(10000);
  v_clob clob;
  v_char char;
  v_create varchar2(1000):='';
  v_create_script varchar2(10000);
  v_alter varchar2(10000);
  v_insert varchar2(1000):='';
  contor pls_integer:=0;
  out_file utl_file.file_type;
begin
  out_file:=utl_file.fopen('EXPORTT','fisier.sql','W');
  DBMS_METADATA.SET_TRANSFORM_PARAM(DBMS_METADATA.session_transform,'SQLTERMINATOR', true);
  DBMS_METADATA.SET_TRANSFORM_PARAM(DBMS_METADATA.session_transform,'SEGMENT_ATTRIBUTES', false);
  DBMS_METADATA.SET_TRANSFORM_PARAM(DBMS_METADATA.session_transform,'CONSTRAINTS_AS_ALTER', TRUE);
  DBMS_METADATA.SET_TRANSFORM_PARAM(DBMS_METADATA.session_transform,'REF_CONSTRAINTS', FALSE);   
  for j in (select * from all_objects where owner=v_owner and object_type=v_tip)
  loop
      v_create:=q'[select dbms_metadata.get_ddl('TABLE',]'||q'[']'||j.object_name||q'[']'||') from dual';
      EXECUTE IMMEDIATE v_create into v_create_script;
      utl_file.putf(out_file,replace(v_create_script,'"STUDENT".','')||'\n/\n');
      v_cursor:=dbms_sql.open_cursor;
      v_execute:='select * from '||j.object_name||' where rownum<2';
      dbms_sql.parse(v_cursor,v_execute,dbms_sql.native);
      dbms_sql.describe_columns(v_cursor,v_count,v_tipcoloana);
      dbms_output.put_line(v_count);
      for i in 1..v_count loop
        --dbms_output.put_line(v_tipcoloana(i).col_type);
        if v_tipcoloana(i).col_type=2 then dbms_sql.define_column(v_cursor,i,v_numar);
        elsif v_tipcoloana(i).col_type=12 then dbms_sql.define_column(v_cursor,i,v_data);
        --elsif v_tipcoloana(i).col_type=1 then dbms_sql.define_column(v_cursor,i,v_string,1000);
        --elsif v_tipcoloana(i).col_type=187 then dbms_sql.define_column(v_cursor,i,v_timestamp,1000);
        elsif v_tipcoloana(i).col_type=112 then dbms_sql.define_column(v_cursor,i,v_clob);
        elsif v_tipcoloana(i).col_type=96 then dbms_sql.define_column(v_cursor,i,v_char,2);
        else dbms_sql.define_column(v_cursor,i,v_string,1000);
        end if;
      end loop;
      v_inutil:=dbms_sql.execute(v_cursor);
      while dbms_sql.fetch_rows(v_cursor)>0 loop
        v_insert:='';
        v_insert:=v_insert||'INSERT INTO '||j.object_name||' values(';
        for i in 1 .. v_count loop
          if v_tipcoloana(i).col_type=2 then 
            dbms_sql.column_value(v_cursor,i,v_numar);
            dbms_output.put_line(v_numar||' '||v_tipcoloana(i).col_name);
            if contor=v_count-1 then
              v_insert:=v_insert||v_numar||')';
            else
              v_insert:=v_insert||v_numar||',';
            end if;
          --elsif v_tipcoloana(i).col_type=1 then
           -- dbms_sql.column_value(v_cursor,i,v_string);
            --dbms_output.put_line(v_string||' '||v_tipcoloana(i).col_name);
          elsif v_tipcoloana(i).col_type=12 then
            dbms_sql.column_value(v_cursor,i,v_data);
            dbms_output.put_line(v_data||' '||v_tipcoloana(i).col_name);
            if contor=v_count-1 then
              v_insert:=v_insert||q'[']'||v_data||q'[']'||')';
            else
              v_insert:=v_insert||q'[']'||v_data||q'[']'||',';
            end if;
          --elsif v_tipcoloana(i).col_type=187 then 
           -- dbms_sql.column_value(v_cursor,i,v_timestamp);
           -- dbms_output.put_line(v_timestamp||' '||v_tipcoloana(i).col_name);
          elsif v_tipcoloana(i).col_type=112 then 
            dbms_sql.column_value(v_cursor,i,v_clob);
            dbms_output.put_line(v_clob||' '||v_tipcoloana(i).col_name);
            if contor=v_count-1 then
              v_insert:=v_insert||q'[q'[]'||v_clob||q'[]]'||q'[']'||')';
            else
              v_insert:=v_insert||q'[q'[]'||v_clob||q'[]]'||q'[']'||',';
            end if;
          elsif v_tipcoloana(i).col_type=96 then 
            dbms_sql.column_value(v_cursor,i,v_char);
            dbms_output.put_line(v_char||' '||v_tipcoloana(i).col_name);
            if contor=v_count-1 then
              v_insert:=v_insert||v_char||')';
            else
              v_insert:=v_insert||v_char||',';
            end if;
          else
            dbms_sql.column_value(v_cursor,i,v_string);
            dbms_output.put_line(v_string||' '||v_tipcoloana(i).col_name);
            if contor=v_count-1 then
              v_insert:=v_insert||q'[q'[]'||v_string||q'[]]'||q'[']'||')';
              --q'[q'[Same'ala]]'||q'[']'
            else
              v_insert:=v_insert||q'[q'[]'||v_string||q'[]]'||q'[']'||',';
            end if;
          end if;
          contor:=contor+1;
        end loop;
        dbms_output.put_line(v_insert);
        utl_file.putf(out_file,replace(v_insert,'"STUDENT".','')||'\n/\n');
        contor:=0;
      end loop;
      dbms_sql.close_cursor(v_cursor);
  end loop;
  DBMS_METADATA.SET_TRANSFORM_PARAM(DBMS_METADATA.session_transform,'REF_CONSTRAINTS', TRUE);
  for j in (select * from all_objects where owner=v_owner and object_type=v_tip) 
  loop
      SELECT count(*) into v_countt FROM user_tables t WHERE table_name IN (j.object_name) AND EXISTS (SELECT 1 FROM user_constraints WHERE table_name = j.object_name AND constraint_type = 'R');
    	if v_countt!=0 then
        v_create:=q'[SELECT dbms_metadata.get_dependent_ddl('REF_CONSTRAINT', table_name) FROM user_tables t WHERE table_name IN (']'||j.object_name||q'[') AND EXISTS (SELECT 1
          		FROM user_constraints WHERE table_name = ']'||j.object_name||q'[' AND constraint_type = 'R')]';
        EXECUTE IMMEDIATE v_create into v_alter;
        v_alter:=replace(v_alter,'ALTER','\n/\nALTER');
        utl_file.putf(out_file,replace(v_alter,'"STUDENT".','')||'/');
      end if;
  end loop;
  for j in (select * from all_objects where object_type in ('FUNCTION','PROCEDURE','VIEW','TRIGGER','PACKAGE','TYPE','INDEX') and owner='STUDENT')
  loop
      v_create:=q'[select dbms_metadata.get_ddl(']'||j.object_type||q'[',]'||q'[']'||j.object_name||q'[']'||') from dual';
      EXECUTE IMMEDIATE v_create into v_create_script;
      --dbms_output.put_line(j.object_type);
      utl_file.putf(out_file,replace(v_create_script,'"STUDENT".','')||'\n/\n');
  end loop;
  utl_file.fclose(out_file);
end;