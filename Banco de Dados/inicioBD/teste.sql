create database teste;

use teste;

create table aluno(

	idAluno int primary key auto_increment,
	matricula int not null unique,
	nome varchar(50) not null,
	sobrenome varchar(50) not null,
	sexo enum('m','f') not null,
	ativo int(1) not null
	
);


create table disciplina(
	
	idDisciplina int primary key auto_increment,
	codigo int(3) not null unique,
	nome varchar(30) not null

);


create table aluno_disciplina(
	
	idAlunoDisciplina int primary key auto_increment,
	id_Aluno int not null,
	id_Disciplina int not null,
	ano int(4) not null,
	pontos int(3) not null,
	aprovado int(1) not null

);


/* Constraints */

alter table aluno_disciplina
add constraint FK_aluno_disciplina_ALUNO
foreign key (id_Aluno) references aluno(idAluno);

alter table aluno_disciplina 
add constraint FK_aluno_disciplina_DISCIPLINA
foreign key (id_Disciplina) references disciplina(idDisciplina);


/* Insert */

--aluno
insert into aluno (matricula,nome,sobrenome,sexo,ativo) values (100,'Marcus','Rosenberg','m',1);
insert into aluno (matricula,nome,sobrenome,sexo,ativo) values (101,'Marcela','Dzeko','f',1);
insert into aluno (matricula,nome,sobrenome,sexo,ativo) values (103,'Jose','Cabana','m',1);

-- select idAluno, concat(nome,' ',sobrenome) as nome, matricula from aluno; concat(str1,str2,...) concatena strings;

--disciplina
insert into disciplina (codigo,nome) values (100,'BD');

--aluno_disciplina
insert into aluno_disciplina (id_Aluno,id_Disciplina,ano,pontos,aprovado) values (1,1,2019,60,1);
insert into aluno_disciplina (id_Aluno,id_Disciplina,ano,pontos,aprovado) values (2,1,2019,59,0);
insert into aluno_disciplina (id_Aluno,id_Disciplina,ano,pontos,aprovado) values (3,1,2019,49,0);


select concat(a.nome," ",a.sobrenome) as 'nome',
		a.matricula as 'matricula',
	   d.nome as 'Disciplina',
	   d.codigo as 'Codigo Disciplina',
	   ta.aprovado as 'Aprovado'	
from aluno a
inner join aluno_disciplina ta
on a.idAluno = ta.id_Aluno
inner join disciplina d
on d.idDisciplina = ta.id_Disciplina
where d.nome='BD' and ta.pontos < 60;

/*

	+---------------+-----------+------------+-------------------+----------+
	| nome          | matricula | Disciplina | Codigo Disciplina | Aprovado |
	+---------------+-----------+------------+-------------------+----------+
	| Marcela Dzeko |       101 | BD         |               100 |        0 |
	| Jose Cabana   |       103 | BD         |               100 |        0 |
	+---------------+-----------+------------+-------------------+----------+


*/

