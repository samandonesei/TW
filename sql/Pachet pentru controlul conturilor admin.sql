CREATE OR REPLACE Package Administrator
as
FUNCTION Login(username admin.nume%type,inputPassword admin.password%type)
return number;
PROCEDURE register_user(username admin.nume%type,inputPassword admin.password%type,email admin.email%type);
PROCEDURE remove_user(username admin.nume%type,inputPassword admin.password%type); 
END Administrator;
/
CREATE OR REPLACE Package Body Administrator as
FUNCTION Login(username admin.nume%type,inputPassword admin.password%type)
return number
IS
entries integer;
BEGIN
  Select count(*) into entries from Admin where nume like username and password like inputPassword;
  if entries != 1 then
    return 0;
  end if;
  return 1;
END;

PROCEDURE register_user(username admin.nume%type,inputPassword admin.password%type,email admin.email%type)
IS
BEGIN
  Insert into Admin values (username,inputPassword,email);
END;

PROCEDURE remove_user(username admin.nume%type,inputPassword admin.password%type)
is
BEGIN
delete from admin where nume like username and password like inputPassword;
     exception
     when NO_DATA_FOUND then
       raise_application_error (-20004,'Contul nu u fost gasit in baza de date.');
END;
end Administrator;

--BEGIN
  --Administrator.register_user('Marcel','Fagarasi','marcel.fagarasi@email.com');
--  Administrator.remove_user('Marcel','Fagarasi');
  --en:=Administrator.Login('Marcel','Fagarasi'); 
--END;
