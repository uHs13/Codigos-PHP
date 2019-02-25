create table usuario(

	idUsuario int primary key auto_increment,
    login varchar(64) not null,
    pass varchar(256) not null,-- nunca devemos salvar a senha final do usuário, precisamos encriptá-las;
    dtRegister timestamp not null default current_timestamp()

);

/*Informamos somente as duas colunas que precisamos realmente passar valores. idUsuario e dtRegister são inseridos automaticamente pelo banco;  
insert into tabela(colunas) values(valores) - insert declarativo */
insert into usuario (login,pass) values ('cj','igotagun');
insert into usuario (login,pass) values ('dmx','whereDAHOOD');
insert into usuario (login,pass) values ('Big Smoke','followthedamntraincj');

update usuario
set pass='wheredahoodat'
where idUsuario=2 and login='dmx';

delete from usuario
where idUsuario=3 and login='Big Smoke';