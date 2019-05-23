/* Modelagem física do banco */

CREATE TABLE Cliente(
	nome varchar(50),
	email varchar(100),
	telefone varchar(30),
	endereco varchar(100),
	sexo char(1),
	cpf int(11)/*11 é a quantidade máxima de caracteres que um int suporta, logo pode dar erro. É aconselhado utilizar varchar para tipar números que não vão ser utilizados em cálculos, como CPF, CNPJ; */
);
/*Passos pra criar e usar : */

/*1°*/
Create database nomeDatabase;
Create database Projeto;/*<----- Banco usado no exemplo da tabela acima (table Cliente)*/
/*2°*/
Use nomeDatabase;
/*3°*/
create table nomeTabela(
	/*nomeatributo tipodeDado(tamanho), => vírgula só se não for a última coluna da tabela*/
	nome VARCHAR(30),
	cpf int(11)
);

/* Para ver as tabelas do banco*/
SHOW TABLES; /*TUDO MAIÚSCULO*/

/*Ver uma tabela com detahes*/
DESC nomeTabela;

/*Inserir Dados nas tabelas*/
Insert into nomeTabela values(valores);
Insert into Cliente values("Heitor Souza","heitorhenriquedias@gmail.com","31996584702","Rua do bairro, numero entre 0 e infinito, complemento","m",151778);
/* Passando dessa maneira os valores(parâmetros do values()) têm de vir na exata ordem em que estão dispostos no BD*/

/* Inserir passando as colunas - Insert Declarativo */
Insert into Cliente (cpf,endereco,sexo,email,nome,telefone) values (151778,"Rua do bairro, numero entre 0 e infinito, complemento","m","heitorhenriquedias@gmail.com","Heitor Souza","31996584702");
/* Dessa maneira conseguimos passar os dados na ordem que quisermos já que especificamos em que colunas eles devem ser inseridos. Os argumentos têm de ser passados na exata ordem de especificação das colunas*/

/* Insert Compacto (ele é colado com o pata rachada? não..., apenas conseguimos passar mais de um registro com as informações, basta separá-los por vírgula)*/
insert into Cliente values("Heitor Souza","heitorhenriquedias@gmail.com","31996584702","Rua do bairro, numero entre 0 e infinito, complemento","m",151778),("Hector Sosa","hectorHenrinchSosa@hotmail.com","31999658741","Rua do bairro, numero entre 0 e 13000, complemento","m",121171);
/* Esse método facilita a inserção de dados, porém só é aceito em bancos de dados MySql */

/* SELECT*/
SELECT Now();/* Essa função retorna a Data e a Hora do Banco de Dados*/

SELECT 'Mensagem'; /* O banco mostra a mensagem na tela*/

SELECT 'Mensagem' as 'String'; /* O banco mostra a mensagem na coluna string*/

SELECT nome,email FROM Cliente;/* Retorna nome e email de todas as tuplas da tabela Cliente*/


/*NUNCA USAR ESSE COMANDO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
SELECT * FROM Cliente;/*Retorna todos os dados de todas as tuplas da tabela Cliente*/


/*A união de colunas nos fornece um registro*/


/*Filtragem de dados*/

SELECT nome,cpf FROM Cliente WHERE sexo='m';/*retorna todos os registros da tabela Cliente que atendem aos requisitos, sexo='m'*/

SELECT nome,cpf from Cliente where cpf=121171;

select nome as nombre from Cliente where nome like='Hector Sosa';

select nome as nombre from Cliente where cpf like '1%';/*Selecionar nome do Cliente onde cpf começa com 1 termina com qualquer coisa */

select nome as nombre from Cliente where cpf like '%1';/* onde cpf começa com qualquer coisa e termina com 1*/

select nome as nombre from Cliente where cpf like '%8%';/*retorna todos que tem 8 no cpf. Mesmo o cpf sendo em números temos que deixar entre aspas para usar o %*/

select count(nome) as nmrClientes from Cliente;/* conta e devolve a quantidade de nomes existentes na tabela cliente. Como cada cliente é obrigado a ter um nome, é valido fazer assim*/

select nome, count(cpf) as 'quantidade' from Cliente group by nome;/* O group by separa, de acordo com o atributo passado, as tuplas retornadas em grupos de semelhantes*/

select nome,email from Cliente where telefone is null;/* retornando tuplas que têm atributos nulos*/

/*Utilizar UPDATE sempre com a cláusula Where*/
update nomeTabela set atributo=valor where condições;
update Cliente set telefone=99854154713 where nome='marreco'; --comentário de uma linha;

--Usar Delete sempre com where;  Quando a tabela tem auto_increment, no id por exemplo, o delete deixa rastro. Se temos 4 registros e deletarmos o registro 4, o próximo a ser cadastrado terá o id 5. A tabela vai ficar (1,2,3,5); 
delete from nomeTabela where condições;
delete from Cliente where nome='Heitor Souza';

/*1ª FORMA NORMAL*/

/*1 - Todo campo vetorizado se tornará outra tabela 

	['Ford','Ferrari','Maserati','Tesla Motors','Mercedes']-> Dados da mesma natureza - Montadoras;
	
	Em um banco de dados essa regra se aplica por exemplo ao atributo telefone. Não é interessante manter dois números em um mesmo espaço na tabela
	, ex.: [998765432 - 992341567], isso geraria erros futuros, não conseguiriamos contar o número total de telefones dentro da nossa base de dados, 
	a query retornaria uma informação errada (errada por culpa de má modelagem, o computador só faz o que a gente manda e ainda faz certo) e informações 
	erradas podem levar uma empresa a falência. A solução seria seguir esse principio da primeira forma normal e criar uma tabela telefone.

*/

/* 2 - todo campo multivalorado se tornará outra tabela - campo divisível - A diferença do campo vetorizado para o multivalorado é que no multivalorado os elementos não são da mesma natureza. No endereço( que é multivalorado ) temos strings e números. No vetor de montadoras( vetorizado ) apenas strings.
	
	Na nossa tabela Cliente temos um exemplo desse tipo de campo, Endereço. Nele estamos armazenando tudo junto 'rua, número e bairro', isso 
	geraria erros de consulta e consequentemente informações erradas. A solução para essa situação é também a criação de uma nova tabela para armazenarmos esses dados.

*/

/* 3 - Toda tabela necessita de pelo menos um campo que idetifique todo o registro como sendo único - Chave Primária PRIMARY KEY
	
	Na nossa tabela Cliente poderiamos falar, ah blz bota o cpf de primary ai e boa. Mas é um principio não modelarmos NUNCA baseados em procedimentos,
	principalmente externos, pois os procedimentos podem sofrer alterações. O cpf é um número que quem controla é a receita federal, se no futuro a regra 
	de numeração mudar, o nosso banco perderia a validade da chave primária, e isso é um problema sério. 
	
	Chave Natural - Dado que provém do que está sendo cadastrado, o cpf por exemplo é um número que já está ''''embutido'''' nos dados do cliente e nenhum outro
	vai ter uma numeração igual, pois é uma regra externa o CPF ser único para identificar um cidadão. Usando chaves naturais corremos o risco da regra externa mudar 
	e termos de refazer todo o banco.
	
	Chave Artificial - Campo criado para a identificação de um registro ( id ou algo assim ).

*/

/* REMODELAGEM CLIENTE - Modelo Físico */

Create database comercio; -- cria o banco;

use comercio; -- após criar temos que nos conectar;

create table cliente(
	idCliente int PRIMARY KEY AUTO_INCREMENT, -- auto_increment o banco controla o número do id;
	nome varchar(30) not null, -- impede o cadastro de um cliente sem nome;
	sexo enum('m','f') not null, --enum são opções pré definidas
	email varchar(50) unique, -- não podemos falar que é not null porque muita gente não tem email. unique fala que o valor tem que ser único na tabela. O email não pode repetir na coluna email;
	cpf varchar(14) unique --14 pra colocar  .   . - ; 
);

create table telefone(

	idTelefone int primary key auto_increment,
	tipo enum('com','res','cel'),
	numero varchar(10),
	ddd char(2),
	id_Cliente int --O tipo é igual ao tipo na tabela de onde a fk veio. O Nome de uma chave estrangeira por convenção tem underline;
	foreign key (id_Cliente)        /* foreign key (nomedaChavenaTabela) references  nomedaTabeladeOndeVeio(nomedaPKNessaTabela)*/
	references cliente(idCliente)	
	
);

create table endereco(

	idEndereco int primary key auto_increment,
	rua varchar(30) not null,
	bairro varchar(30) not null,
	cidade varchar(30) not null,
	estado char(2) not null	
	id_Cliente int unique, -- O Nome de uma chave estrangeira por convenção tem underline. Um cliente não pode ter dois endereços;
	foreign key(id_Cliente)
	references cliente(idCliente)
	
);
/*
	Foreign Key é a chave primária de uma tabela que vai até outra fazer referência
	
	Em relacionamentos 1x1 a chave estrangeira fica na tabela mais fraca, a que não faz sentido existir sem a outra ( Ex.: Endereço sem nenhum cliente );
	
	Em relacionamentos 1xn a chave estrangeira fica na tabela n;
*/

/* Inserts */

--Não convém utilizar o insert compacto ( com vários 'arrays' com values de uma só vez ) porque esse método só é aceito em bancos mysql, ficariamos mal acostumados;
insert into cliente values(null,'joao','m','jaumzin22@gmail.com','98547-6');
insert into cliente values(null,'carlos','m','caca171@hotmail.com','86641-7');
insert into cliente values(null,'ana','f','ahtaldaana@gmail.com','75658-5');
insert into cliente values(null,'clara','f',null,'99754-7');
insert into cliente values(null,'celia','f','celinhadaquebrada@hotmail.com','77558-5');
-- o null no inicio do values é a chave primária, como ela é auto_increment o banco que determina o valor;
insert into endereco values(null,'Belgica','Eldorado','Contagem','MG',2);--esse último número é o id do cliente que o endereço pertence
insert into endereco values(null,'Espanha','Eldorado','Contagem','MG',5);
insert into endereco values(null,'Inglaterra','Eldorado','Contagem','MG',3);
insert into endereco values(null,'Veneza','Eldorado','Contagem','MG',4);
insert into endereco values(null,'Franca','Eldorado','Contagem','MG',1);
--Cliente com mais de um telefone é pra demonstrar e lembrar que podemos cadastrar mais de um telefone pra um cliente;
insert into telefone values(null,'com','985471234','31',1);--esse último número é o id do cliente que o telefone pertence. Isso garante a integridade referencial, temos um registro sempre relacionado com outro existente, um telefone "amarrado" a um cliente;
insert into telefone values(null,'res','978452165','31',3);
insert into telefone values(null,'cel','963987412','31',2);
insert into telefone values(null,'res','912954871','31',5);
insert into telefone values(null,'cel','953867542','31',4);
insert into telefone values(null,'res','954653298','31',1);
insert into telefone values(null,'cel','914253687','31',3);


/* Seleção, projeção e junção */

-- Projeção: Tudo o que queremos mostrar (projetar) na tela;

Select now();--mostra a data e a hora do banco de dados;
Select nome, now() as "data" from cliente;

--Seleção: Banco de dados é teoria dos conjuntos. Seleção seleciona um subconjunto de dados do todo;

/* Where é a cláusula de seleção*/
select nome,sexo from cliente where sexo='f';

update telefone set numero=25674530 where idTelefone=2 and id_Cliente=3;

--Junção: 

--NUNCA FAZER ISSO DESSE JEITO:
select nome,sexo,rua,cidade, now() as "data"
from cliente,endereco
where idCliente = id_Cliente;
--NUNCA FAZER ISSO. WHERE É CLÁUSULA DE SELEÇÃO NÃO DE JUNÇÃO. COMO NÃO EXISTE ENDEREÇO 'SOLTO' ( PRA TER ENDEREÇO PRECISAMOS DE UM CLIENTE ) ESSE WHERE VAI SER SEMPRE VERDADE PRA TODOS OS REGISTROS.
--Relaciona a chave primária de cliente com a estrangeira de endereco.
/* Retorna os dados com a relação idCliente=id_Cliente, ou seja, 
as informações indivíduais de cada cliente*/ 

--JEITO CERTO - COM JOIN:

--2 tabelas ( A do from e a do inner join)
select nome,sexo,rua,cidade,now() as 'data' -- Projeção
from cliente 
inner join endereco -- Junção
on idCliente=id_Cliente 
where sexo='f'; -- Seleção

--3 tabelas:

--temos que especificar de quais tabelas vêm esses dados
select cliente.nome, cliente.sexo, endereco.rua, endereco.cidade, telefone.tipo, telefone.ddd, telefone.numero -- tabela.atributo == ponteiro;
from cliente
inner join endereco
on cliente.idCliente = endereco.id_Cliente
inner join telefone
on cliente.idCliente = telefone.id_Cliente
where cliente.sexo='m';
-- como podemos ter mais de uma tupla de telefone relacionada com o mesmo cliente ( um cliente pode ter mais de um número ) vão ser retornadas mais de uma linha com o mesmo cliente, mas não é erro de redundância ( O computador está sempre certo ).

select c.nome, e.bairro, t.ddd, t.tipo, t.numero
from cliente c -- damos nomes reduzidos para as tabelas para podermos referenciá-las de maneira mais fácil;
inner join endereco e
on c.idCliente = e.id_Cliente
inner join telefone t
on c.idCliente = t.id_Cliente
where c.sexo = 'f';

/* Oficina do José */
/*
	BD chamado projeto
	
	Sr.josé quer modernizar a sua oficina, e por enquanto, cadastrar os carros que entram
	para realizar os serviços e os respectivos donos. Sr josé mencionou que cada cliente
	possui apenas um carro. Um carro possui uma marca. Sr.José também quer saber as
	cores dos carros para ter idéia de qual tinta comprar, e informa que um carro pode ter
	mais de uma cor. Sr josé precisa armazenar os telefones dos clientes, mas não quer
	que eles sejam obrigatórios.
	
*/

create database projeto;

use projeto;

create table cliente(

	idCliente int primary key auto_increment,
	nome varchar(30) not null, --não dar espaço entre o tipo de dado e o outro atributo ( not null nesse caso) não causa erros;
	cpf varchar(14) unique
	
);

create table carro(
	
	idCarro int primary key auto_increment,
	montadora varchar(20) not null,
	modelo varchar(20) not null,
	id_Cliente int unique, -- Usar _ para indicar que é uma chave estrangeira. É uma convenção.
	foreign key (id_Cliente)
	references cliente(idCliente)
	
);

create table servicos(
	
	idServico int primary key auto_increment,
	nome varchar(30) not null,
	descricao varchar(30),
	preco int(5) not null,
	id_Cliente int unique,
	id_Carro int unique,
	
	foreign key (id_Cliente)
	references cliente(idCliente), --vírgula entre chaves diferentes e atributos diferentes;
	
	foreign key (id_Carro)
	references carro(idCarro)
	
);

create table cores(
	
	idCor int primary key auto_increment,
	nome varchar(100) not null,
	id_Carro int unique,
	
	foreign key (id_Carro)
	references carro(idCarro)
	
	
	
);
--números que não vão ser utilizados em cálculos tipá-los como varchar;
create table telefone(
	
	idTelefone int primary key auto_increment,
	ddd int(2),
	numero varchar(10), 
	id_Cliente int unique,
	foreign key (id_Cliente)
	references cliente(idCliente)
	
);

--inserindo clientes       null por causa da chave primária, não podemos dar valor porque é o banco que gerencia;
insert into cliente values(null,'Mario Gallo','789.654-13');
insert into cliente values(null,'Connie Guiseppe','159.753-62');
insert into cliente values(null,'Ezio Auditore','351.953-84');

--inserindo carros       1:1 - 1 cliente só possui 1 carro;
insert into carro values(null,'Lamborghini','Urus',2);
insert into carro values(null,'Alfa Romeo','Giulia Veloce',3);
insert into carro values(null,'Maserati','Levante',1);

--inserindo servicos     
insert into servicos(idServico,nome,preco,id_Cliente,id_Carro) values(null,'Troca de oleo','330',1,3);
insert into servicos(idServico,nome,preco,id_Cliente,id_Carro) values(null,'Substituicao de amortecedor','4000',2,1);
insert into servicos(idServico,nome,preco,id_Cliente,id_Carro) values(null,'Pintura','5520',3,2);

--inserindo cores 
insert into cores values(null,'Carbono Fosco',2);
insert into cores values(null,'Indigo Meia Noite',3);
insert into cores values(null,'Preto perolado em Verde Esmeralda ',1);

--inserindo telefone
insert into telefone values(null,'+39','15445871',1);
insert into telefone values(null,'+39','45876598',2);
insert into telefone values(null,'+39','32548712',3);
-- para inerir mais de um telefone para um cliente é só repetir o processo e colocar o id do cliente a que pertence no final;

--Query
select c.nome as 'Cliente',cr.montadora,cr.modelo,cor.nome as 'Cor',s.nome as 'Servico',s.preco as 'Preco',t.ddd,t.numero
from cliente c
inner join carro cr
on c.idCliente = cr.id_Cliente  
inner join servicos s
on  s.id_Cliente = c.idCliente
inner join cores cor 
on cr.idCarro = cor.id_Carro
inner join telefone t 
on c.idCliente = t.id_Cliente;

/*relação correta: Vem fora de ordem de idCliente porque os serviços estão cadastrados 3 1 2 - ezio, mario, connie;
	
	Mario - Maserati - Levante - Indigo Meia Noite - Troca de óleo - 330 - +39 - 15445871
	
	Connie - Lamborghini - Urus - Preto perolado em verde esmaralda - Substituição de amortecedor - 4000 - +39 - 45876598
	
	Ezio  - Alfa Romeo - Guilia Veloce - Carbono Fosco - Pintura - 5520 - +39 - 32548712
	
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Cliente         | montadora   | modelo        | Cor                                | Servico                     | Preco | ddd  | numero   |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Ezio Auditore   | Alfa Romeo  | Giulia Veloce | Carbono Fosco                      | Pintura                     |  5520 |   39 | 32548712 |
	| Mario Gallo     | Maserati    | Levante       | Indigo Meia Noite                  | Troca de oleo               |   330 |   39 | 15445871 |
	| Connie Guiseppe | Lamborghini | Urus          | Preto perolado em Verde Esmeralda  | Substituicao de amortecedor |  4000 |   39 | 45876598 |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	
 */
 
 --Correção de preço como string:
 update servicos set preco=330 where id_Cliente=1;
 update servicos set preco=4000 where id_Cliente=2;
 update servicos set preco=5520 where id_Cliente=3;
 
 
 /* Voltando pro banco comércio */
 
 select c.nome,c.email,t.ddd,t.numero 
 from cliente c
 inner join telefone t
 on c.idCliente = t.id_Cliente
 inner join endereco e
 on c.idCliente = e.id_Cliente
 where e.bairro = 'eldorado' and e.rua='Belgica' or e.rua='Franca'; -- se colocar and no lugar do or não retorna nada porque não tem cliente com dois endereços( A regra de negócio não permite ), somente dois telefones;
/* 
	+--------+---------------------+------+-----------+
	| nome   | email               | ddd  | numero    |
	+--------+---------------------+------+-----------+
	| carlos | caca171@hotmail.com | 31   | 963987412 |
	| joao   | jaumzin22@gmail.com | 31   | 985471234 |
	| joao   | jaumzin22@gmail.com | 31   | 33920530  |
	+--------+---------------------+------+-----------+

*/

select c.nome, c.email, t.ddd , t.numero
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e -- Chama a tabela endereço mesmo ela não sendo usada na projeção porque ela é usada na seleção, onde o bairro for 'Eldorado'. 
on c.idCliente = e.id_Cliente
where c.sexo='f' and bairro='eldorado';

/*
	+-------+-------------------------------+------+-----------+
	| nome  | email                         | ddd  | numero    |
	+-------+-------------------------------+------+-----------+
	| celia | celinhadaquebrada@hotmail.com | 31   | 33922239  |
	| ana   | ahtaldaana@gmail.com          | 31   | 25674530  |
	| ana   | ahtaldaana@gmail.com          | 31   | 914253687 |
	| clara | NULL                          | 31   | 953867542 |
	+-------+-------------------------------+------+-----------+

*/

-- Função Ifnull() - recebe como parâmetro a coluna que pode retornar um valor nulo e um valor para substituir o null caso ele seja retornado; 

select c.nome, 
	   ifnull(c.email,' - ') as Email, -- tem que colocar o alias pra não ficar a função e os parâmetros como nome da coluna; 
	   t.ddd,
	   t.numero
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e 
on c.idCliente = e.id_Cliente
where c.sexo='f' and bairro='eldorado';

/*
	Quando temos um relacionamento :n (0:n ou 1:n) os relacionamentos da primeira ponta podem se repetir caso tenha mais de um registro relacionado com uma mesma
	chave primária da primeira ponta. Nesse caso ana se repete porque ela tem mais de um telefone cadastrado no seu nome;
	+-------+-------------------------------+------+-----------+
	| nome  | Email                         | ddd  | numero    |
	+-------+-------------------------------+------+-----------+
	| celia | celinhadaquebrada@hotmail.com | 31   | 33922239  |
	| ana   | ahtaldaana@gmail.com          | 31   | 25674530  |
	| ana   | ahtaldaana@gmail.com          | 31   | 914253687 |
	| clara |  -                            | 31   | 953867542 |
	+-------+-------------------------------+------+-----------+
	O email da clara foi substituido de null para - como informado na função ifnull(c.email,' - ')
*/

-- VIEWS - Em questão de performance a view é lenta, na view estamos acessando uma query através de outra;

--Criar o nome da view com v_ para direfenciá-las das tabelas;  NÃO CONSEGUIMOS EXCLUIR NEM INSERIR DADOS EM VIEWS;
create view v_oficina as
select c.nome as 'Cliente',cr.montadora,cr.modelo,cor.nome as 'Cor',s.nome as 'Servico',s.preco as 'Preco',t.ddd,t.numero
from cliente c
inner join carro cr
on c.idCliente = cr.id_Cliente  
inner join servicos s
on  s.id_Cliente = c.idCliente
inner join cores cor 
on cr.idCarro = cor.id_Carro
inner join telefone t 
on c.idCliente = t.id_Cliente;

/*Pequena observação: usar select * from tabela é ruim e lento. Embora tenhamos que digitar mais passando coluna por coluna, a query fica mais rápida;
	
	select * from v_oficina;
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Cliente         | montadora   | modelo        | Cor                                | Servico                     | Preco | ddd  | numero   |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Ezio Auditore   | Alfa Romeo  | Giulia Veloce | Carbono Fosco                      | Pintura                     |  5520 |   39 | 32548712 |
	| Mario Gallo     | Maserati    | Levante       | Indigo Meia Noite                  | Troca de oleo               |   330 |   39 | 15445871 |
	| Connie Guiseppe | Lamborghini | Urus          | Preto perolado em Verde Esmeralda  | Substituicao de amortecedor |  4000 |   39 | 45876598 |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	3 rows in set (0.08 sec) <---
	
	//CONSULTANDO OS DADOS DA VIEW;
	
	select Cliente,montadora,modelo,Cor,Servico,Preco,ddd,numero from v_oficina;
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Cliente         | montadora   | modelo        | Cor                                | Servico                     | Preco | ddd  | numero   |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Ezio Auditore   | Alfa Romeo  | Giulia Veloce | Carbono Fosco                      | Pintura                     |  5520 |   39 | 32548712 |
	| Mario Gallo     | Maserati    | Levante       | Indigo Meia Noite                  | Troca de oleo               |   330 |   39 | 15445871 |
	| Connie Guiseppe | Lamborghini | Urus          | Preto perolado em Verde Esmeralda  | Substituicao de amortecedor |  4000 |   39 | 45876598 |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	3 rows in set (0.00 sec) <---
		
*/

--Conseguimos fazer filtros normalmente dentro de views:

select Cliente,montadora,modelo from oficina
where Preco = 4000; 
/*
	+-----------------+-------------+--------+
	| Cliente         | montadora   | modelo |
	+-----------------+-------------+--------+
	| Connie Guiseppe | Lamborghini | Urus   |
	+-----------------+-------------+--------+
*/
-- Apagando a view
drop view nomeview;

/*ORDER BY
	
	Os dados retornados do banco por uma query são chamados de DataSet.
	O order by serva para ordenar esse data set;
*/

select c.nome, c.email,c.cpf, t.ddd, t.numero, e.bairro, e.rua
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by c.nome;

/*

	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| nome   | email                         | cpf     | ddd  | numero    | bairro   | rua        |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 25674530  | Eldorado | Inglaterra |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 914253687 | Eldorado | Inglaterra |
	| carlos | caca171@hotmail.com           | 86641-7 | 31   | 963987412 | Eldorado | Belgica    |
	| celia  | celinhadaquebrada@hotmail.com | 77558-5 | 31   | 33922239  | Eldorado | Espanha    |
	| clara  | NULL                          | 99754-7 | 31   | 953867542 | Eldorado | Veneza     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 985471234 | Eldorado | Franca     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 33920530  | Eldorado | Franca     |
	+--------+-------------------------------+---------+------+-----------+----------+------------+

*/

-- podemos também colocar o ASC junto ao order by para mostrar que queremos algum atributo de maneira ascendente ( menor pro maior );

select c.nome, c.email,c.cpf, t.ddd, t.numero, e.bairro, e.rua
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by t.numero asc; -- pedindo pra ordenar por número de celular de maneira ascendente ( não faz muito sentido ordenar por celular, mas é o atributo que mais mexe na ordem da tabela. Ordenar por cpf ficaria muito parecido com o exemplo de cima.

/*
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| nome   | email                         | cpf     | ddd  | numero    | bairro   | rua        |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 25674530  | Eldorado | Inglaterra |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 33920530  | Eldorado | Franca     |
	| celia  | celinhadaquebrada@hotmail.com | 77558-5 | 31   | 33922239  | Eldorado | Espanha    |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 914253687 | Eldorado | Inglaterra |
	| clara  | NULL                          | 99754-7 | 31   | 953867542 | Eldorado | Veneza     |
	| carlos | caca171@hotmail.com           | 86641-7 | 31   | 963987412 | Eldorado | Belgica    |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 985471234 | Eldorado | Franca     |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
*/

--ordenando por duas colunas:

select c.nome, c.email,c.cpf, t.ddd, t.numero, e.bairro, e.rua
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by c.nome, t.numero asc;

/*
	Nos clientes com mais de um número ( ana e joão que se repetem) a prioridade passa a ser o número menor ('res' antes do 'cel');
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| nome   | email                         | cpf     | ddd  | numero    | bairro   | rua        |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 25674530  | Eldorado | Inglaterra |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 914253687 | Eldorado | Inglaterra |
	| carlos | caca171@hotmail.com           | 86641-7 | 31   | 963987412 | Eldorado | Belgica    |
	| celia  | celinhadaquebrada@hotmail.com | 77558-5 | 31   | 33922239  | Eldorado | Espanha    |
	| clara  | NULL                          | 99754-7 | 31   | 953867542 | Eldorado | Veneza     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 33920530  | Eldorado | Franca     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 985471234 | Eldorado | Franca     |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
*/

-- Podemos dar um order by no número da coluna. Vai ordenar pela coluna referente ao número:

select c.nome, c.email,c.cpf, t.ddd, t.numero, e.bairro, e.rua
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by 7; -- Ordena a coluna rua;

/*
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| nome   | email                         | cpf     | ddd  | numero    | bairro   | rua        |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| carlos | caca171@hotmail.com           | 86641-7 | 31   | 963987412 | Eldorado | Belgica    |
	| celia  | celinhadaquebrada@hotmail.com | 77558-5 | 31   | 33922239  | Eldorado | Espanha    |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 985471234 | Eldorado | Franca     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 33920530  | Eldorado | Franca     |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 25674530  | Eldorado | Inglaterra |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 914253687 | Eldorado | Inglaterra |
	| clara  | NULL                          | 99754-7 | 31   | 953867542 | Eldorado | Veneza     |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
*/

/* DELIMITADOR E ESTADO DO SERVIDOR
	
   STATUS -> retorna informações sobre o servidor;
   
   DELIMITER símbolo -> troca o delimitador pelo símbolo passado;

*/

/* PROCEDURES */
/* O delimitador foi trocado de ; para $ */

--estrutura básica das procedures:
create procedure nome()
begin
	comandos;
end
$

create procedure allData()
begin

select c.nome,c.sexo,ifnull(c.email,' - ')as 'email',c.cpf,t.tipo,t.ddd,t.numero,e.rua,e.bairro,e.cidade,e.estado
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by c.nome;

end
$

/* Chamando a procedure*/

call nomeProcedure()$

call allData()$

/* Apagagando a procedure*/
drop procedure nome$
drop procedure allData$

/* Procedure com parâmetros */
                         --colocar o p_ na frente para indicar que é um parâmetro
create procedure allData(p_sexo char)
begin

select c.nome,c.sexo,ifnull(c.email,' - ')as 'email',c.cpf,t.tipo,t.ddd,t.numero,e.rua,e.bairro,e.cidade,e.estado
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
where c.sexo = p_sexo --Só retorna os clientes com o sexo determinado no parâmetro;
order by c.nome;

end
$

/* Tabela Produto*/
--Não precisa colocar not null em primary key que já é auto_increment, toda vez que cadastrar o banco já vai colocar um valor automaticamente;
create table produto(
	
	idProduto int primary key auto_increment,
	nome varchar(20) not null,
	valor float(5,2) not null
	
);

/* Tabela Compra*/
create table compra(
	
	idCompra int primary key auto_increment,
	valor float(10,2) not null,
	dtCompra timestamp not null default current_timestamp, --current_timestamp retorna a data e hora atuais. Nesse caso vai registrar a data e a hora que o registro foi inserido no banco; 
	id_Produto int not null,
	id_Cliente int unique not null,
	
	foreign key (id_Produto)
	references produto(idProduto),
	
	foreign key (id_Cliente)
	references cliente(idCliente)
	
);

/* Inserts */

insert into produto(nome,valor) values ('margarina',5);
insert into produto(nome,valor) values ('arroz',16);
insert into produto(nome,valor) values ('feijao',8);
insert into produto(nome,valor) values ('pao',9.99);

insert into compra(valor,id_Produto,id_Cliente) values (50,1,2);
insert into compra(valor,id_Produto,id_Cliente) values (160,2,1);
insert into compra(valor,id_Produto,id_Cliente) values (6.50,4,3);
insert into compra(valor,id_Produto,id_Cliente) values (80,3,4);

/* Query*/


/* Procedure para cadastrar uma compra*/              --colocar o p_ na frente para indicar que é um parâmetro;
create procedure newPurchase(p_moneySpent float(10,2),p_productId int(3),p_clientId int(3))
begin
	insert into compra(valor,id_Produto,id_Cliente) values (p_moneySpent,p_productId,p_clientId);
end
$

call newPurchase(200,4,5);

/* Procedure para visualizar as compras*/
create procedure showPurchases()
begin
	select c.nome,p.nome as 'Produto',cm.valor as 'Total da Compra',cm.dtCompra as 'Data'
	from cliente c
	inner join compra cm
	on c.idCliente = cm.id_Cliente
	inner join produto p
	on p.idProduto = cm.id_Produto
	order by c.nome;
end
$

call showPurchases();

/* FUNÇÕES DE AGREGAÇÃO */

/* MAX(coluna) retorna o maior valor da coluna especificada*/
select max(cp.valor) as 'Maior compra' 
from compra cp;

--Retorna o valor da maior compra e o nome do cliente que a fez
set @mx = (select max(cp.valor) from compra cp);
select @mx as 'Maior compra',c.nome
    from compra cp
    inner join cliente c
    on cp.id_Cliente = c.idCliente
	where cp.valor = @mx;
	/*
		+--------------+-------+
		| Maior compra | nome  |
		+--------------+-------+
		|          200 | celia |
		+--------------+-------+
	*/


/* MIN(coluna) retorna o menor valor da coluna especificada*/
select min(cp.valor) as 'Menor compra' 
from compra cp;

-- Retorna o valor da menor compra e o nome do cliente que a fez
set @mx = (select min(cp.valor) from compra cp);
select @mx as 'Menor compra',c.nome
    from compra cp
    inner join cliente c
    on cp.id_Cliente = c.idCliente
	where cp.valor = @mx;
	
	/*
		+--------------+------+
		| Menor compra | nome |
		+--------------+------+
		|          6.5 | ana  |
		+--------------+------+	
	*/
		

/* AVG(coluna) retorna a média de todos os valores da coluna específicada*/
--truncate(valor,casas decimais) -> retona o valor com o número de casas decimais específicadas;
select truncate(avg(cp.valor),2) as 'Media de gastos'
from compra cp;

	/*
		+-----------------+
		| Media de gastos |
		+-----------------+
		|           99.30 |
		+-----------------+
	*/

/* SUM(coluna) retorna todos os valores somados */
select sum(cp.valor) as 'Total de gastos' 
from compra cp;

	/*
		+-----------------+
		| Total de gastos |
		+-----------------+
		|          496.50 |
		+-----------------+

	*/
	
/* Um banco de dados serve para pegar dados e gerar informações com esses dados*/

/*Valor gasto por sexo*/
select c.sexo, sum(cp.valor)  as 'Gastos'
from compra cp
inner join cliente c
on c.idCliente = cp.id_Cliente
group by c.sexo;

	/*
		+------+--------+
		| sexo | Gastos |
		+------+--------+
		| m    | 210.00 |
		| f    | 286.50 |
		+------+--------+
	*/
	
	
/*Quem gastou mais que a média */
set @md = (select avg(cp.valor) from compra cp);
select c.nome, cp.valor, @md as 'Media de compra' 
from cliente c
inner join compra cp
on c.idCliente = cp.id_Cliente
where cp.valor > @md
order by c.nome;

	/* 
		+-------+--------+-----------------+
		| nome  | valor  | Media de compra |
		+-------+--------+-----------------+
		| celia | 200.00 |            99.3 |
		| joao  | 160.00 |            99.3 |
		+-------+--------+-----------------+
	*/

--Usando subQuery

select c.nome, cp.valor, @md as 'Media de compra' -- Outer query  - Query de fora
from cliente c
inner join compra cp
on c.idCliente = cp.id_Cliente
where cp.valor > (select avg(cp.valor) from compra cp) -- ( Inner query ) query dentro de outra query - subSelect;
order by c.nome;
	/*
		+-------+--------+-----------------+
		| nome  | valor  | Media de compra |
		+-------+--------+-----------------+
		| celia | 200.00 |            99.3 |
		| joao  | 160.00 |            99.3 |
		+-------+--------+-----------------+
	*/

/* Operações na linha */
select c.nome, 
	   cp.valor,
	  (cp.valor *.3) as 'Desconto de 30%',
	  (cp.valor - (cp.valor *.3)) as 'Total a pagar'
from cliente c
inner join compra cp
on c.idCliente = cp.id_Cliente  --sempre colocar o on; 
where cp.valor > (select avg(cp.valor) from compra cp);

	/*
		+-------+--------+-----------------+---------------+
		| nome  | valor  | Desconto de 30% | Total a pagar |
		+-------+--------+-----------------+---------------+
		| joao  | 160.00 |           48.00 |        112.00 |
		| celia | 200.00 |           60.00 |        140.00 |
		+-------+--------+-----------------+---------------+

	*/
	
/* Reescrevendo a procedure showPurchases() */
create procedure showPurchases()
begin
	select c.nome, 
		   cp.valor,
	      (cp.valor *.3) as 'Desconto de 30%',
	      (cp.valor - (cp.valor *.3)) as 'Total a pagar'
    from cliente c
    inner join compra cp
    on c.idCliente = cp.id_Cliente   
    where cp.valor > (select avg(cp.valor) from compra cp);
end
$

/* ALTERANDO TABELAS */
create table Colunas(
	coluna1 varchar(30),
	coluna2 varchar(30),
	coluna3 varchar(30)
);

--Adicionando uma chave primária:
alter table nomeTabela
add primary key (nome_coluna);

alter table Colunas
add primary key (coluna1); -- Não dá pra colocar auto_increment quando colocamos a primary key por fora ( com alter table ), só na hora de criar;

--Adicionando uma coluna sem posição específica ( Fazendo desta maneira, por padrão, a coluna vai pra última posição da tabela ):
alter table nomeTabela
add nomeColuna tipodeDado(tamanho) --Sempre coolocar o tipo de dado;

alter table Colunas
add coluna varchar(30);

alter table colunas
add coluna13 int;

--Adicionando uma coluna com posição específica:
alter table colunas
add coluna11 varchar(30) not null unique 
after coluna;

--Modificando o tipo de um campo:
alter table nomeTabela
modify nomeColuna novoTipodeDado(tamanho) not null unique;

alter table colunas 
modify coluna13 varchar(30) not null; --para modificar a estrutura de um campo os valores têm de ser compatíveis ( uma coluna char ou varchar com o valor 'carl' não pode ser modificada pra int. Mas uma coluna char com o valor '13' pode ser trocado pra int ) ou então o campo tem que estar vazio, sem nenhum dado cadastrado;

--Adicionando uma FK:

--Como a FK tem que ser do mesmo tipo da PK da tabela que vai ser importada e não temos um campo int, vamos realterar a coluna 13;
alter table colunas
modify coluna13 int(2);

alter table colunas
add foreign key (coluna13)
references cliente(idCliente);

--Renomeando a tabela:
alter table Colunas
rename coluna;

--Ver as chaves de uma tabela:
SHOW CREATE TABLE nomeTabela;

SHOW CREATE TABLE coluna;

/* Convenção de criação de PK e FK -  Constraints ( Regra de integridade referencial ) */
-- A PK garante que o registro seja único na tabela e a FK garante que não vamos ter nenhum registro solto ou 'orfão';



/* Não é uma boa prática criarmos as chaves ( PK e FK ) juntamente com a tabela.  */


create database convencao;

use convencao;

create table cliente(
	
	idCliente int,
	nome varchar(10) not null
	
);

create table telefone(

	idTelefone int,
	tipo enum('cel','res','com') not null,
	numero varchar(10) not null,
	id_Cliente int
	
);

alter table cliente add constraint pk_cliente  -- Adicionando PK e FK a parte;
primary key (idCliente);

alter table telefone add constraint fk_cliente_telefone
foreign key (id_Cliente) references cliente(idCliente);

show create table telefone;

/*  
| telefone | CREATE TABLE `telefone` (
  `idTelefone` int(11) DEFAULT NULL,
  `tipo` enum('cel','res','com') NOT NULL,
  `numero` varchar(10) NOT NULL,
  `id_Cliente` int(11) DEFAULT NULL,
  KEY `fk_cliente_telefone` (`id_Cliente`),
  CONSTRAINT `fk_cliente_telefone` FOREIGN KEY (`id_Cliente`) REFERENCES `cliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci |
*/

/* Acessando dicionário de dados*/

use information_schema; --Banco com as informações de todos os bancos criados;

desc table_constraints; --Tabela com as constraints ( regras ) de todos os bancos;

select constraint_schema as "Banco de Origem", --projeção
	   table_name as "Tabela",
	   constraint_name as "Nome da Regra",
	   constraint_type as "Tipo de Chave"
	   from table_constraints
	   where constraint_schema='projeto'; -- seleção;
	   

/*
	+-----------------+----------+---------------------+---------------+
	| Banco de Origem | Tabela   | Nome da Regra       | Tipo de Chave |
	+-----------------+----------+---------------------+---------------+
	| convencao       | cliente  | PRIMARY             | PRIMARY KEY   |
	| convencao       | telefone | fk_cliente_telefone | FOREIGN KEY   |
	+-----------------+----------+---------------------+---------------+
*/

/* Apagando Constraints*/

use convencao;

alter table telefone
drop foreign key fk_cliente_telefone;


/* TRIGGER */

use convencao;

create table cliente(

	idCliente int primary key auto_increment,
	nome varchar(10) not null,
	login varchar(20) not null,
	senha varchar(100) not null
		
);

create table bkp_cliente(
	
	idBkp int primary key auto_increment,
	idUsuario int,
	nome varchar(10),
	login varchar(20)

);


insert into cliente (nome,login,senha) values ('Benzema','k9bzm','halamadrid');
insert into cliente (nome,login,senha) values ('lukaku','lukatk','reddevils');
insert into cliente (nome,login,senha) values ('Higuain','gonzalo','milan123');
insert into cliente (nome,login,senha) values ('Heitor','uHs13','hector');
insert into cliente (nome,login,senha) values ('Arthur','arthur','bolazul');
insert into cliente (nome,login,senha) values ('Cebastia1','ElBoladon','123cabron');


/* Criando a trigger */

Create trigger nome
before/after insert/update/delete on nometabela
for each row
begin
 ...
end
$


create trigger bkp_cliente_delete
before delete on cliente
for each row
begin

	insert into backup.bkp_cliente (idCliente,nome,login,autor,evento) values (old.idCliente,old.nome,old.login,current_user(),'DELETE');
	
end
$

create database backup; --Backup lógico;  Backup físico seria backup em outro servidor, em fita;

use backup;

create table bkp_cliente(
	
	idBkp int primary key auto_increment,
	idCliente int,
	nome varchar(10),
	login varchar(20),
	
);


-- Comunicação entre bancos 

--Estamos no banco backup e inserindo dados na tabela cliente do banco convencao;
insert into convencao.cliente (nome,login,senha) values ('Higuain','gonzalo','milan123');


/* Trigger para comunicacao */

use convencao$

create trigger backup_cliente_insert
after insert on cliente
for each row
begin
	insert into backup.bkp_cliente(idCliente,nome,login,autor,evento) values(new.idCliente,new.nome,new.login,current_user(),'INSERT');
end
$

insert into convencao.cliente(nome,login,senha) values ('Heitor','uHs13','hector');

--Excluir um trigger

drop trigger nomeTrigger;

drop trigger backup_cliente;

--Adicionando coluna de Evento a tabela de backup
--Isso foi feito antes da alteração que adicionou o campo direto pelo código de criação da tabela;
alter table backup.bkp_cliente
add Action varchar(7);

/*

	drop trigger bkp_cliente;
	drop table backup.bkp_cliente;

*/

--refatoração da tabela bkp_cliente. Os triggers foram também refatorados;

use backup;

create table bkp_cliente(
	
	idBkp int primary key auto_increment,
	idCliente int,
	nome varchar(10),
	login varchar(20),
	dt timestamp default current_timestamp,
	autor varchar(30),
	evento varchar(7)
	
);

use convencao;

delimiter $

create trigger bkp_cliente_update
before update on cliente
for each row
begin
	
	insert into backup.bkp_cliente(idCliente,nome,login,autor,evento) values (old.idCliente,old.nome,new.login,current_user(),'UPDATE');

end
$

delimiter ;


/* Auto Relacionamento */

use convencao

create table curso(

	idCurso int primary key auto_increment,
	nome varchar(30) not null,
	valor float(8,2) not null,
	horas int(3) not null,
	id_Curso int

);

alter table curso
add constraint fk_curso_curso
foreign key (id_Curso)
references curso(idCurso);

/* Inserts */

insert into curso (nome,valor,horas,id_Curso) values ('logica de programacao',50,30,null);
insert into curso (nome,valor,horas,id_Curso) values ('C',100,30,1);
insert into curso (nome,valor,horas,id_Curso) values ('C++',150,40,2);
insert into curso (nome,valor,horas,id_Curso) values ('Java',100,90,1);
insert into curso (nome,valor,horas,id_Curso) values ('PHP',23,30,1);
insert into curso (nome,valor,horas,id_Curso) values ('JavaScript',23,30,1);

/* Query */

delimiter $

select c.idCurso,c.nome,c.valor,c.horas,ar.nome as 'pre-requisito'
from curso c
inner join curso ar
on c.id_Curso = ar.idCurso;


create procedure showCourses()
begin 

	select c.idCurso,
		   c.nome,
		   c.valor,
		   c.horas,
		   ifnull(ar.nome,"---") as 'pre-requisito'
		   
	from curso c left join curso ar -- left join considera até os cursos que não têm pré requisito
	on ar.idCurso = c.id_Curso;
	

end
$

/* CURSORES */

use convencao

create table vendedor(

	idVendedor int primary key auto_increment,
	nome varchar(30) not null,
	jan int not null,
	fev int not null,
	mar int not null	

);

create table vendedor_stats(
	
	nome varchar(30) not null,
	jan int not null,
	fev int not null,
	mar int not null,
	media int not null,
	total int not null	

);


insert into vendedor (nome,jan,fev,mar) values ('Joaquim',100000,89541,122330);
insert into vendedor (nome,jan,fev,mar) values ('Barbara',113000,95178,197340);
insert into vendedor (nome,jan,fev,mar) values ('Rafaela',452001,92258,332547);
insert into vendedor (nome,jan,fev,mar) values ('Eustaquio',630000,25000,157121);

select idVendedor, 
	   nome, 
	   (jan+fev+mar) as 'Total',
	   (jan+fev+mar)/3 as 'Media'
from vendedor;

-- criando um cursor para inserir todos os dados presentes na tabela vendedor na vendedor_stats juntamente com a media e o total
-- Cursor é uma programação dentro de uma procedure

delimiter $

create procedure cursor_insertData()
begin
	
	declare fim int default 0;
	declare vmes1,vmes2,vmes3,vtotal,vmedia int; 
	declare vnome varchar(30);
	
	declare rgst cursor for(
	
		select nome, jan, fev, mar from vendedor
	
	);
	
	declare continue handler for not found set fim = 1;
	
	open rgst;
	
	repeat
	
		fetch rgst into vnome, vmes1, vmes2, vmes3;
		
		if not fim then
			
			set vtotal = vmes1 + vmes2 + vmes3;
			set vmedia = vtotal / 3;
			
			insert into vendedor_stats (nome,jan,fev,mar,total,media) values (vnome,vmes1,vmes2,vmes3,vtotal,vmedia);
			
		end if;
		
	until fim end repeat;
	
	close rgst;
			
end
$

--Outro exemplo de cursor no banco oficina ( arquivo Oficina.sql);

/* SEGUNDA E TERCEIRA FORMAS NORMAIS

	Se aplicam em situações que tem a presença de uma chave composta.
	
	 2ª - Para atender a segunda forma normal qualquer chave que não seja chave tem que depender da totalidade do conjunto união das chaves associativas
	
	 3ª - Dependência transitiva - Campos não chave que dependem de outros campos não chave, a relação entre eles vira outra tabela

*/

create database consultorio;

use consultorio;

create table paciente(
	
	idPaciente int primary key auto_increment,
	nome varchar(30) not null,
	cpf char(11) not null unique,
	sexo enum('m','f') not null,
	email varchar(50) not null unique,
	dtRegistro timestamp default current_timestamp
	
); 

create table especialidade(
	
	idEspecialidade int primary key auto_increment,
	nome varchar(30) not null unique

);

create table medico(
	
	idMedico int primary key auto_increment,
	nome varchar(30) not null,
	cpf char(11) not null unique,
	sexo enum('m','f') not null,
	funcionario enum('s','n') not null,
	id_Especialidade int not null

);

create table hospital(
	
	idHospital int primary key auto_increment,
	nome varchar(30) not null unique

);


create table consulta(

	idConsulta int primary key auto_increment,
	dtRegistro timestamp default current_timestamp,
	diagnostico varchar(30) not null,
	id_Paciente int not null,
	id_Medico int not null,
	id_Hospital int not null

);

create table internacao(

	idInternacao int primary key auto_increment,
	entrada timestamp default current_timestamp,
	saida timestamp default current_timestamp,
	quarto int not null,
	observacoes varchar(50),
	id_Consulta int not null unique	

);

/* Constraints */

alter table medico
add constraint FK_MEDICO_ESPECIALIDADE
foreign key(id_Especialidade) references especialidade(idEspecialidade);

alter table consulta
add constraint FK_CONSULTA_PACIENTE
foreign key(id_Paciente) references paciente(idPaciente);

alter table consulta
add constraint FK_CONSULTA_MEDICO
foreign key(id_Medico) references medico(idMedico);

alter table consulta
add constraint FK_CONSULTA_HOSPITAL
foreign key(id_Hospital) references hospital(idHospital);

alter table internacao
add constraint FK_INTERNACAO_CONSULTA
foreign key(id_Consulta) references consulta(idConsulta);

/* Inserts */

-- paciente -- 
insert into paciente(nome,cpf,sexo,email) values ('Eustaquio',11122255598,'m','eu_stack_io@gmail.com');
insert into paciente(nome,cpf,sexo,email) values ('Karmen',33344488819,'f','kk.123.98@gmail.com');

-- especialidade -- 
insert into especialidade(nome) values ('Cardiologia');
insert into especialidade(nome) values ('Pneumologia');

-- medico --
insert into medico(nome,cpf,sexo,funcionario,id_Especialidade) values ('Francisca',15478932812,'f','s',2);
insert into medico(nome,cpf,sexo,funcionario,id_Especialidade) values ('Geraldo',98465132470,'m','s',1);

-- hospital --
insert into hospital (nome) value ('TouchDown');

-- consulta -- 
insert into consulta (diagnostico,id_Paciente,id_Medico,id_Hospital) values ('Bronquite',1,2,1);
insert into consulta (diagnostico,id_Paciente,id_Medico,id_Hospital) values ('Arritmia',3,1,1); 

-- internacao -- 
insert into internacao (quarto,observacoes,id_Consulta) values (13,'impedir o agravamento do quadro',1); 
insert into internacao (quarto,observacoes,id_Consulta) values (47,'Acompanhamento de progresso do tratamento',2);

/* Query */

-- nome paciente, nome do medico, nome especialidade, nome hospital, diagnostico, data de consulta, 

DELIMITER $

create procedure showMedicalCheck()
begin

	select p.nome as 'Paciente',
		   h.nome as 'Hospital',
		   e.nome as 'Especialidade',
		   m.nome as 'Medico',
		   c.diagnostico as 'Diagnostico',
		   c.dtRegistro as 'Data' 
	from consulta c 
	inner join paciente p
	on c.id_Paciente = p.idPaciente
	inner join hospital h
	on c.id_Hospital = h.idHospital
	inner join medico m
	on c.id_Medico = m.idMedico 
	inner join especialidade e 
	on m.id_Especialidade = e.idEspecialidade;
	  
end
$

-- mostra os detalhes das internações ocorridas

delimiter $

create procedure report_hospitalization()
begin 
	select p.nome as 'Paciente',
		   h.nome as 'Hospital',
		   e.nome as 'Especialidade',
		   m.nome as 'Medico',
		   c.diagnostico as 'Diagnostico',
		   i.quarto as 'Quarto',
		   i.observacoes as 'Observacoes',
		   i.entrada as 'Entrada',
		   i.saida as 'saida'
	from internacao i 
	inner join consulta c 
	on i.id_Consulta = c.idConsulta
	inner join paciente p
	on c.id_Paciente = p.idPaciente
	inner join hospital h
	on c.id_Hospital = h.idHospital
	inner join medico m
	on c.id_Medico = m.idMedico 
	inner join especialidade e 
	on m.id_Especialidade = e.idEspecialidade;
end
$	

/* SQL SERVER*/

-- comentário é a mesma coisa /**/ -- 

-- Delimitador GO - Quebra os comandos em pacotes tcp ip independentes que chegam em ordem para a execução. Tem que ter quebra de linha antes de usar o GO

-- ctrl + r -> esconde e mostra o painel 

/* Criando um banco de dados  */

create database sql_teste
go 

use sql_teste 
go 

create table usuario(

	idUsuario int primary key identity,
	nome varchar(30) not null,
	email varchar(100) not null unique
);
go

--inserts
insert into usuario (nome,email) values ('Heitor','heitorhenriquedias@gmail.com')
go

--query 
select idUsuario, nome, email from usuario
go

/* Arquitetura 

	 Como se coportam os arquivos que compõem o banco de dados
	 
	 NOME LÓGICO : nome que vemos o arquivo no management studio
	 NOME DO ARQUIVO ( FÍSICO ) : como está salvo no HD
	 
	 Pasta DATA : Guarda os arquivos referentes a todos os bancos de dados que temos no mangement studio
	 
	 .mdf : Master Data File ( Guarda dados ) 
	 
	 .ldf : Log Data File  ( guarda logs ) 
	 
	 Sempre que criamos um banco sem alterar as configurações são gerados .mdf e.ldf 
	 
	 Quando adicionamos dados em uma tabela estamos adicionando no .mdf.  Quando estamos preenchendo o .mdf estamos gerando uma transação,
	 transação é um grupo lógico que é utilizado para garantir a integridade dos dados. Esse grupo lógico pode ser executado ou não. 
	 Tudo que é executado em uma transação fica salvo no .ldf ( arquivo de log ) para garantir que possa ser desfeito, garantir que
	 a transação possa voltar ( Todos os comando da transação pertencem a um unico bloco, pricipio da atomicidade ). Assim que a transação
	 é confirmada os dados do .ldf ( arquivo de log ) são escritos no .mdf. Se a transação for cancelada os dados são apagados do arquivo
	 de log e nada ocorre
	 
	 
	 É uma boa prática deixar o .mdf apenas para dados do sistema ( dicionaário de dados )
	 Usamos .ndf para armazenar os dados
	 Criamos grupos de arquivos para separar os .ndf -> organização lógica
	 Fazemos uma separação lógica e também física
	 
	 Todo  banco tem um grupo padrão chamado primary. O .mdf fica dentro dele
	 
	 arquivos de log (.ldf) não entram em nenhum grupo de arquivos
	 

*/

/* Criando tabelas */
use empresa

--idAluno int primary key identity(nmrInicial,incremento) - podemos passar essa informação, mas não é obrigatório

create table aluno(
	
	idAluno int primary key identity,
	nome varchar(30) not null,
	sexo char(1) not null,
	nascimento date not null,
	email varchar(30) not null unique


)
go 

-- DEFININDO RELACIONAMENTO 1x1 ENTRE AS TABELAS ALUNO E ENDEREÇO

--colocando o unique no id_Aluno estamos dizendo que ele não pode se repetir, ou seja, um aluno só tem um endereço (1X1)

create table endereco(
	
	idEndereco int identity(100,10),
	bairro varchar(30) not null,
	uf char(2) not null,
	id_Aluno int not null unique
	
)
go

--não podemos especificar tamanho de int no sql server

create table telefone(

	idTelefone int identity,
	ddd char(2),
	tipo char(3),
	numero varchar(10),
	id_Aluno int 

)
go


/* Constraint  - CHECK */

alter table aluno 
add constraint CK_SEXO 
check (sexo in('m','f'))
go

alter table telefone
add constraint CK_TIPO
check (tipo in('cel','res','com'))
go

-- não podemos alterar a PK de aluno  porque ela foi criada junto com a tabela, mas podemos alterar seu nome clicando com o botão direito sobre a chave

/* CONSTRAINT  - PK */

alter table endereco
add constraint PK_ENDERECO
primary key (idEndereco)
go

alter table telefone 
add constraint PK_TELEFONE
primary key (idTelefone)
go

/* CONSTRAINT  - FK */

alter table endereco
add constraint FK_ENDERECO_ALUNO
foreign key (id_Aluno) references aluno(idAluno)
go

alter table telefone 
add constraint FK_TELEFONE_ALUNO
foreign key (id_Aluno) references aluno(idAluno)
go



/* COMANDOS DE DESCRIÇÃO */

-- no sql server os comandos de descrição são procedures já definidas e armazenadas no sistema que nos trazem informações sobre os bancos e tabelas
-- SP (storage procedure)

SP_COLUMNS nomeTabela -- traz uma descrição da estrutura da tabela
go

SP_HELP nomeTabela -- traz uma descrição ainda mais detalhada sobre a tabela 
go 



/* INSERTS */

-- formato de date é ano/mes/dia

-- aluno   
insert into aluno (nome,sexo,nascimento,email) values ('Joao','m','1978/09/13','joao@gmail.com')
insert into aluno (nome,sexo,nascimento,email) values ('Julia','f','1990/03/18','ju.lia@gmail.com')
insert into aluno (nome,sexo,nascimento,email) values ('Juscelino','m','1902/08/12','jk@gmail.com')
insert into aluno (nome,sexo,nascimento,email) values ('Jandira','m','1994/11/22','jandira@gmail.com')
go

--endereco
insert into endereco (bairro,uf,id_Aluno) values ('Eldorado','MG',1);
insert into endereco (bairro,uf,id_Aluno) values ('Agua Branca','MG',2);
insert into endereco (bairro,uf,id_Aluno) values ('Tropical','MG',3);
insert into endereco (bairro,uf,id_Aluno) values ('Glória','MG',4);
go

--telefone 
insert into telefone (ddd,tipo,numero,id_Aluno) values ('31','cel','996584702',1)
insert into telefone (ddd,tipo,numero,id_Aluno) values ('31','cel','998745124',2)
go



-- Pegar data e hora do sistema
select getdate()
go

-- Query  - nossas colunas são nossas projeções
select a.nome,
	   isnull(t.ddd,'--') as "ddd",
	   isnull(t.tipo,'SEM') as "tipo",
	   isnull(t.numero,'NUMERO') as 'numero',
	   e.bairro,
	   e.uf
from aluno a 
left join telefone t 
on a.idAluno = t.id_Aluno
inner join endereco e
on a.idAluno = e.id_Aluno 
go

--IntelliSense verifica erros sintáticos e semânticos

/* FUNÇÕES SQL SERVER - https://www.w3schools.com/sql/sql_ref_sqlserver.asp */

-- DATEDIFF : Calcula a diferenca entre duas datas  DATEDIFF(formato_do_intervalo,dataInicial,DataFinal) 
select idAluno,
		  nome,
		  datediff(year,nascimento,getdate()) as 'idade'  
		  from aluno
go

--DATENAME : Traz o nome ( string ) da parte especificada da data passada como argumento
select idAluno,
		  nome,
		  datename(weekday,nascimento) as 'dia de nascimento'  ,
		  datename(month,nascimento) as 'mes de nascimento'  
		  from aluno
go

--DATEPART : traz o numero referente a parte da data especificada 
select idAluno,
		  nome,
		  datepart(weekday,nascimento) as 'dia de nascimento'  ,
		  datepart(month,nascimento) as 'mes de nascimento'  
		  from aluno
go

--DATEADD : Traz uma data somada a outra 
select idAluno,
		  nome,
		  nascimento,
		  dateadd(year,10,nascimento) as '10 anos depois'  
		  from aluno
go


/* modelos de formato_do_intervalo  - VÁLIDOS PARA TODAS AS FUNÇÕES DE DATA ACIMA 

	year, yyyy, yy = Year
	quarter, qq, q = Quarter -> retorna o numero de trimestres
	month, mm, m = month
	dayofyear = Day of the year -> dayofyear e day retornam o numero de dias 
	day, dy, y = Day ->            
	week, ww, wk = Week
	weekday, dw, w = Weekday -> traz o dia da semana
	hour, hh = hour
	minute, mi, n = Minute
	second, ss, s = Second
	millisecond, ms = Millisecond


*/

/* CONVERSÃO DE DADOS */

/* + operador lógico de soma e de concatenação de strings 
	
	1 + 1 == 2 
	1 + '1' == 2
	'1' + '1' == 11
		
	O sql server por padrão tenta converter uma string para um número quando usamos o + 	
	
*/

select cast('1' as int) + cast('1' as int)
go

select idAluno,
		  nome,
		  concat(day(nascimento),'/',month(nascimento),'/',year(nascimento)) as 'data de nascimento'
		  datediff(year,nascimento,getdate()) as 'idade'  
		  from aluno
go

--CHARINDEX : retorna a o indice da primeira aparição de um caracter dentro de  uma string
--charindex(oq,onde,posicaoInicial)

select nome, charindex('a',nome) from aluno -- quando não passamos de onde começar inicia em zero

select nome, charindex('a',nome,3) from aluno -- quando passamos de onde começar todos os caracteres antes são desconsiderados na contagem, porém o valor que é retornado é referente a primeira ocorrencia na palavra toda . ex.: charindex('a',nome,3) -> Jandira  7. O primeiro a foi ignorado, pois a contagem se inicia na letra n. como o resultado considera a palavra toda o retorno foi 7 e não 5.

/* BULK INSERT - importando dados de arquivos externos para tabelas */

use empresa

create table banco(
		conta int,
		valor int,
		acao char(1)

)
go

bulk insert banco
from 'C:\CONTAS.txt'
with(
	
	firstrow = 2,
	datafiletype = 'char',
	fieldterminator = '\t',
	rowterminator='\n'

)
go

/* Exibindo o saldo das contas */
select conta,
		  valor,
		  charindex('d',acao) as 'Debito',
		  charindex('c',acao) as 'Credito'
		  charindex('c',acao) * 2 - 1 as 'Multiplicador'
from banco
go


select conta,
sum(valor * (charindex('c',acao) * 2 - 1)) as saldo
from banco 
group by conta 
go


/* TRIGGERS DML */

use school
go

create table categoria (
	
	idCategoria int identity,
	nome varchar(30) not null
	
)
go 

create table produto(
	
	idProduto int identity,
	nome varchar(30) not null,
	preco number(6,2) not null,
	id_Categoria int

)
go

create table registro(
	
	idRegistro int identity,
	nomeProduto varchar(30) not null,
	nomeCategoria varchar(30) not null,
	precoAntigo numeric(6,2) not null,
	precoNovo numeric(6,2) not null,
	idCategoria int,
	horario datetime,
	usuario varchar(30),
	detalhe varchar(100)
	
)
go

-- constraints

alter table categoria
add constraint PK_CATEGORIA 
primary key (idCategoria)
go

alter table produto 
add constraint FK_PRODUTO_CATEGORIA
foreign key (id_Categoria) references categoria(idCategoria)
go

alter table registro 
add constraint PK_REGISTRO
primary key (idRegistro)
go 


--insert 

--categoria 
insert into categoria (nome) values ('Alimento')
insert into categoria (nome) values ('Limpeza')
insert into categoria (nome) values ('Higiene')
go

--produto 
insert into produto (nome,preco,id_Categoria) values ('Pão',9.9,1)
insert into produto (nome,preco,id_Categoria) values ('Farinha de milho',2.5,1)
insert into produto (nome,preco,id_Categoria) values ('Desinfetante',8,2)
insert into produto (nome,preco,id_Categoria) values ('Cloro',5,2)
insert into produto (nome,preco,id_Categoria) values ('Desodorante',10,3)
insert into produto (nome,preco,id_Categoria) values ('Polvilho Antisséptico',10,3)
go


-- query 
select p.nome as "Produto",
	   p.preco as "Preco",
	   c.nome as "Categoria"
from produto p 
inner join categoria c 
on p.id_Categoria = c.idCategoria 
go	   




-- TRIGGER

--bloco de programação nomeado
create trigger trg_controle_registro
on dbo.produto
for update as
if update (preco) 
begin 
	
	--bloco de declaração de variáveis
	declare @nomeProduto varchar(30)
	declare @nomeCategoria varchar(30)
	declare @precoAntigo numeric(6,2)
	declare @precoNovo numeric(6,2)
	declare @idCategoria int 
	declare @horario datetime 
	declare @usuario varchar(30)
	declare @detalhe varchar(100)
	
	--bloco de atibuição de valores 

	--Valores vindos de tabelas são atribuidos pelo select 
	select @nomeProduto = nome from inserted
	select @idCategoria = id_Categoria from inserted 
	select @precoAntigo = preco from deleted
	select @precoNovo = preco from inserted 
	
	--valores de retorno de funções e literais são atribuidos pelo set 
	set @nomeCategoria = (select nome from categoria  where idCategoria = @idCategoria)
	set @horario = getdate()
	set @usuario = suser_name()
	set @detalhe = 'trg_controle_registro data'
	
	insert into registro (nomeProduto,nomeCategoria,precoAntigo,precoNovo,idCategoria,horario,usuario,detalhe) 
	values (@nomeProduto,@nomeCategoria,@precoAntigo,@precoNovo,@idCategoria,@horario,@usuario,@detalhe)
	
	print 'trg_controle_registro executada'
end
go

-- query 
select nomeProduto,nomeCategoria,precoAntigo,precoNovo,idCategoria,horario,usuario,detalhe from registro 
go

select idProduto,nome,preco,id_Categoria from produto
go


/* Refatorando a trigger */
drop trigger trg_controle_registro
go

-- OBS
/*
	A trigger é um exemplo de bloco de programação nomeado, pois ela recebe um identificador ( nome ) e é salva no banco.
	Um bloco de programação anônimo só é executado uma vez e não é armazenado no banco 

*/

--bloco anônimo 

declare
	@resultado int 
	select @resultado = (select 13*13) 
	print 'Resultado:'+cast(@resultado as varchar)
	go
	
-- FIM OBS

create table funcionario (
	
	idFuncionario int identity,
	nome varchar(30) not null,
	salario money not null,
	idGerente int 

) 
go

-- constraints 
alter table funcionario 
add constraint FK_FUNCIONARIO_GERENTE 
foreign key (idGerente) references funcionario(idFuncionario) 
go 

alter table funcionario 
add constraint PK_FUNCIONARIO 
primary key (idFuncionario)
go

-- insert 
insert into funcionario (nome,salario) values ('Joaquim',2876.33) 
insert into funcionario (nome,salario) values ('Francisca',3214.69) 
insert into funcionario (nome,salario,idGerente) values ('Alfredo',2200.00,2) 
insert into funcionario (nome,salario,idGerente) values ('Marina',2345.90,1)
go

--query 
 
select f.nome as 'Nome',
	      f.salario as 'Salario',
	      isnull(fs.nome,'---') as 'GERENTE' -- conversão de int para varchar 
from funcionario f
left join funcionario fs 
on  f.idGerente = fs.idFuncionario
go

create table hist_salario(
	
	idHist_salario int identity,
	nome varchar(30) not null,
	salarioAn money not null,
	salarioNv money not null, 
	data_hora datetime 
)
go


--constraints 
alter table hist_salario 
add constraint PK_HIST_SALARIO 
primary key (idHist_salario)
go 


create trigger trg_att_salario 
on dbo.funcionario 
for update as 
if update(salario) 
begin 
	
	insert into hist_salario (nome,salarioAn,salarioNv,data_hora)
	select d.nome,d.salario,i.salario,getdate() 
	from deleted d 
	inner join inserted i 
	on d.idFuncionario = i.idFuncionario 
	print 'trg_att_salario executada'
	
end 
go

update funcionario 
set salario*=1.1 
where salario < 3000 
go -- afeta marina, alfredo e joaquim 


--query 
select idHist_salario, nome,salarioAn,salarioNv,data_hora from hist_salario 
go


create table range_salario(
	
	idRange_salario int identity,
	piso money,
	teto money

)
go

--constraint
alter table range_salario 
add constraint PK_RANGE_SALARIO 
primary key (idRange_salario)
go

--insert 
insert into range_salario (piso,teto) values (998.00,4000) 
go

-- TRIGGER 

/* trigger de controle de salário */
create trigger trg_controla_salario
on dbo.funcionario 
for insert,update
as
	declare
		@mins money,
		@maxs money,
		@curr money 
	
	select @mins = piso, @maxs = teto from range_salario 
	
	select @curr = i.salario 
	from inserted i 
	
	
	
	if(@curr < @mins)
	begin 
		
		raiserror('Salario menor que o piso',16,1)
		rollback transaction
			
	end 
	
	if(@curr > @maxs)
	begin 
		
		raiserror('Salario maior que o teto',16,1)
		rollback transaction
		
	end 
	print 'trg_controla_salario executada'
go

update funcionario 
set salario = 9970 
where idFuncionario = 1
go

update funcionario 
set salario = 997
where idFuncionario = 1
go

select idFuncionario,nome,salario from funcionario 
go


/* Verificando o código de uma trigger */
SP_HELPTEXT nomeTrigger ou nomeProcedure 
go

SP_HELPTEXT trg_controla_salario
go

-- substring 
select substring('frase',1,5) as 'substring' /* A primeira posição da string é 1 */
go

-- projetar todos os bancos de uma instância sql server 
select name, database_id, create_date 
from sys.databases
go

-- projetar todas as tabelas de determinado banco
select table_catalog,
	   table_schema,
	   table_name,
	   table_type 
from information_schema.tables
where table_catalog = 'school'
go


-- PROCEDURE ( Stored procedures )

use school 

-- tabelas --
create table pessoa(

	idPessoa int identity,
	nome varchar(30) not null,
	sexo char(1) not null,
	nascimento date not null  -- formato padrão ano-mes-dia

)
go

create table telefone(

	idTelefone int identity,
	ddd varchar(3) not null,
	tipo char(3) not null,
	numero varchar(10) not null,
	id_Pessoa int

)
go

-- constraints  --

--pessoa
alter table pessoa
add constraint PK_PESSOA
primary key (idPessoa)
go 

alter table pessoa 
add constraint CK_SEXO 
check (sexo in('m','f'))
go 

--telefone 
alter table telefone 
add constraint PK_TELEFONE 
primary key (idTelefone)
go 

alter table telefone 
add constraint CK_TIPO 
check (tipo in('cel','com','res'))
go 

alter table telefone
add constraint FK_TELEFONE_PESSOA 
foreign key (id_Pessoa) references pessoa(idPessoa)
go

-- inserts -- 

/*

pt.fakenamegenerator.com 
http://www.geradordepessoas.com.br

*/

--pessoa
insert into pessoa (nome,sexo,nascimento) values ('Jeans Daecher','m','1960-06-30')
insert into pessoa (nome,sexo,nascimento) values ('Amedeo Piazza','m','1941-06-02')
insert into pessoa (nome,sexo,nascimento) values ('Malene S. Ericksen','f','1969-04-12')
insert into pessoa (nome,sexo,nascimento) values ('Majer Virag','f','1998-02-15') 
go

-- telefone 
insert into telefone (ddd,tipo,numero,id_Pessoa) values ('61','cel','97802-9412',1)
insert into telefone (ddd,tipo,numero,id_Pessoa) values ('19','res','9961-9536',2)
insert into telefone (ddd,tipo,numero,id_Pessoa) values ('11','cel','95297-3702',3)
insert into telefone (ddd,tipo,numero,id_Pessoa) values ('82','res','9572-0271',4)
go

--query 
select p.nome,
	   p.sexo,
	   p.nascimento,
	   t.ddd,
	   t.tipo,
	   t.numero
from pessoa p 
inner join telefone t 
on p.idPessoa = t.id_Pessoa 
go



-- criando procedures 
create proc nome_procedure 
as 
  ...
go 

create proc conta 
as 
	select 10 + 10 as 'soma'
go 

create proc somar @num1, @num2 
as 
	select @num1 + @num2  as 'soma'
go 

-- chamando procedures 
exec nome_procedure 
go 

exec conta 
go 

exec somar 44, 53
go 

-- apagando procedures
drop proc nome_procedure 
go
drop proc conta 
go
drop proc somar 
go 

-- procedure para trazer os dados de pessoa e telefone relacionados 
-- parâmetros de input

create proc showData 
as 
		select p.nome,
		   p.sexo,
		   p.nascimento,
		   t.ddd,
		   t.tipo,
		   t.numero
	from pessoa p 
	inner join telefone t 
	on p.idPessoa = t.id_Pessoa 
go

exec showData 
go 

/*

nome                           sexo nascimento ddd  tipo numero
------------------------------ ---- ---------- ---- ---- ----------
Jeans Daecher                  m    1960-06-30 61   cel  97802-9412
Amedeo Piazza                  m    1941-06-02 19   res  9961-9536
Malene S. Ericksen             f    1969-04-12 11   cel  95297-3702
Majer Virag                    f    1998-02-15 82   res  9572-0271


*/


-- mostra os numeros do tipo passado como parâmetro 
create proc showNumber @typeN char(3) 
as 
		select p.nome,
		   p.sexo,
		   p.nascimento,
		   t.ddd,
		   t.tipo,
		   t.numero
	from pessoa p 
	inner join telefone t 
	on p.idPessoa = t.id_Pessoa 
	where t.tipo = @typeN 
go

exec showNumber 'cel'
go

/*

nome                           sexo nascimento ddd  tipo numero
------------------------------ ---- ---------- ---- ---- ----------
Jeans Daecher                  m    1960-06-30 61   cel  97802-9412
Malene S. Ericksen             f    1969-04-12 11   cel  95297-3702

*/

exec showNumber 'res'
go

/*

nome                           sexo nascimento ddd  tipo numero
------------------------------ ---- ---------- ---- ---- ----------
Amedeo Piazza                  m    1941-06-02 19   res  9961-9536
Majer Virag                    f    1998-02-15 82   res  9572-0271

*/

create proc showNumber_S @sexo char(1)
as
	select p.nome,
		   p.sexo,
		   p.nascimento,
		   t.ddd,
		   t.tipo,
		   t.numero
	from pessoa p 
	inner join telefone t 
	on p.idPessoa = t.id_Pessoa 
	where p.sexo = @sexo 
go 

exec showNumber_S 'f'

/*

nome                           sexo nascimento ddd  tipo numero
------------------------------ ---- ---------- ---- ---- ----------
Malene S. Ericksen             f    1969-04-12 11   cel  95297-3702
Majer Virag                    f    1998-02-15 82   res  9572-0271

*/

exec showNumber_S 'm'

/*

nome                           sexo nascimento ddd  tipo numero
------------------------------ ---- ---------- ---- ---- ----------
Jeans Daecher                  m    1960-06-30 61   cel  97802-9412
Amedeo Piazza                  m    1941-06-02 19   res  9961-9536

*/

-- parâmetros de output  

-- essa query retorna os tipos de numero salvos na tabela telefone e as quantidades de cada um 
select tipo, count(tipo) as 'Quantidade' from telefone
group by tipo
go

-- procedure que retorna a quantidade de numeros de determinado tipo
create procedure getTipo @tipo char(3), @resultado int output 
as 

	select @resultado =  count(tipo) 
	from telefone 
	where tipo=@tipo

go

declare @saida int 
exec getTipo @tipo = 'cel', @resultado = @saida output
select @saida as 'Quantidade'
go

-- executando getTipo
declare @saida int 
exec getTipo 'res',@saida output -- a palavra reservada output é necessária na chamada da procedure
select @saida as 'Quantidade'
go

/*

Quantidade
-----------
2
	
*/

-- procedure que retorna a quantidade de pessoas de determinado sexo 
create proc getSexo @sexo char(1), @resultado int output
as 
	select @resultado = count(sexo) from pessoa 
	where sexo= @sexo 
go

-- executando getSexo 
declare @quantidade int 
exec getSexo 'f', @quantidade output 
select @quantidade as 'numero de pessoas'
go

/*

numero de pessoas
-----------------
2

*/


-- procedure de cadastro de pessoa e telefone ao mesm o tempo 

select @@identity -- retorna o último indice inserido na sessão
go

create proc cadastro @nome varchar(30), @sexo char(3), @nascimento date,
					 @ddd varchar(3), @tipo char(3), @numero varchar(10) 
as 

		declare @FK int 
		
		insert into pessoa(nome,sexo,nascimento) values (@nome, @sexo, @nascimento)
		
		-- set é utilizado para valores literais e retornos de funções 
		-- atribui o último indice atribuido na sessão (última inserção na tabela pessoa) a FK 
		set @FK = (select idPessoa from pessoa where idPessoa = @@identity)
	    
		insert into telefone (ddd,tipo,numero,id_Pessoa) values (@ddd,@tipo,@numero,@FK)
		
go


exec cadastro 'Heitor Souza','m','2000-08-29','31','cel','996584702'
go

exec showData
go

/*
nome                           sexo nascimento ddd  tipo numero
------------------------------ ---- ---------- ---- ---- ----------
Jeans Daecher                  m    1960-06-30 61   cel  97802-9412
Amedeo Piazza                  m    1941-06-02 19   res  9961-9536
Malene S. Ericksen             f    1969-04-12 11   cel  95297-3702
Majer Virag                    f    1998-02-15 82   res  9572-0271
Heitor Souza                   m    2000-08-29 31   cel  996584702
*/


/* TSQL */
/* 
	Transact-SQL é um bloco de programação que pode ser nomeado ou anônimo.
	A diferença entre os dois tipo é que o bloco anônimo não é salvo no banco,
	ele é apenas executado.
*/

-- Blocos TSQL 

begin 

end 
go


begin 
	print 'Daria um filme'
end
go

-- bloco de atribuição de variáveis 
declare
	@music varchar(30) 
begin 
	set @music = 'Capítulo 4 versículo 3'
	print @music 
end 
go


declare
	@v_numerico numeric(10,2) = 113.13,
	@v_data datetime = '20190510'
begin 
	
	print 'valor numerico ' + cast(@v_numerico as varchar)
	print 'valor numerico ' + convert(varchar,@v_numerico)	-- mais usado na conversão de datas
	
	print 'valor data ' + cast(@v_data as varchar)
	print 'valor data ' + convert(varchar,@v_data, 121) -- data  e hora completa (H:m:s:ms)
	print 'valor data ' + convert(varchar,@v_data, 120)	-- data  e hora  (H:m:s)
	print 'valor data ' + convert(varchar,@v_data, 105)	-- data em formato pt-BR

end 
go

-- Atribuindo resultados a variáveis 

create table carros(
	
	idCarros int identity,
	modelo varchar(30) not null,
	montadora varchar(30) not null
		
)
go


-- constraints
alter table carros 
add constraint PK_CARROS
primary key (idCarros)
go

-- inserts 
insert into carros(modelo,montadora) values ('Opala','Chevrolet')
insert into carros(modelo,montadora) values ('Ômega','Chevrolet')
insert into carros(modelo,montadora) values ('Uno','Fiat')
insert into carros(modelo,montadora) values ('Palio','Fiat')
insert into carros(modelo,montadora) values ('Mustang 68 GT','Ford')
insert into carros(modelo,montadora) values ('Fusion','Ford')
insert into carros(modelo,montadora) values ('Civic','Honda')
insert into carros(modelo,montadora) values ('Corolla','Toyota')
go

-- query
select idCarros,modelo,montadora from carros
go

-- procedure 
create proc showCar 
as
		
	select idCarros,modelo,montadora from carros
	

go

exec showCar 
go 

create proc insertCar @modelo varchar(30), @montadora varchar(30)
as
	
	insert into carros (modelo,montadora) values (@modelo,@montadora)
	
go

exec insertCar 'Hilux','Toyota'
go

select count(idCarros) as 'Modelos Toyota' from carros where montadora='Toyota' 
go

-- atribuição de valor a variáveis

--abrindo o bloco anônimo T-SQL 
declare
	
	@v_cont_Chevrolet int,
	@v_cont_Fiat int,
	@v_cont_Ford int,
	@v_cont_Honda int,
	@v_cont_Toyota int,
	@v_cont_total int
	
begin
	/* método 1 - O select tem que retornar um simples coluna e um único resultado*/
	-- o set atribui a variável o resultado de uma query
	set @v_cont_Chevrolet = (select count(idCarros) from carros where montadora='Chevrolet')
	set @v_cont_Fiat = (select count(idCarros) from carros where montadora='Fiat')
	set @v_cont_Ford = (select count(idCarros) from carros where montadora='Ford')
	set @v_cont_Honda = (select count(idCarros) from carros where montadora='Honda')
	set @v_cont_Toyota = (select count(idCarros) from carros where montadora='Toyota')
	set @v_cont_total = (select count(idCarros) from carros)
	
	print 'MÉTODO 1:'
	print 'Modelos Chevrolet: '+ cast(@v_cont_Chevrolet as varchar)
	print 'Modelos Fiat: '+ cast(@v_cont_Fiat as varchar)
	print 'Modelos Ford: '+ cast(@v_cont_Ford as varchar)
	print 'Modelos Honda: '+ cast(@v_cont_Honda as varchar)
	print 'Modelos Toyota: '+ cast(@v_cont_Toyota as varchar)
	print 'Total de carros: '+ cast(@v_cont_total as varchar) + char(13)+char(10)
		
		
	/* método 2 -  Utilizamos a variável dentro do select para definir o seu valor*/
	
	select @v_cont_Chevrolet = count(idCarros) from carros where montadora='Chevrolet'
	select @v_cont_Fiat = count(idCarros)from carros where montadora='Fiat'
	select @v_cont_Ford = count(idCarros)from carros where montadora='Ford'
	select @v_cont_Honda = count(idCarros)from carros where montadora='Honda'
	select @v_cont_Toyota = count(idCarros)from carros where montadora='Toyota'
	select @v_cont_total = count(idCarros) from carros
			
	print 'MÉTODO 2:'
	print 'Modelos Chevrolet: '+ cast(@v_cont_Chevrolet as varchar)
	print 'Modelos Fiat: '+ cast(@v_cont_Fiat as varchar)
	print 'Modelos Ford: '+ cast(@v_cont_Ford as varchar)
	print 'Modelos Honda: '+ cast(@v_cont_Honda as varchar)
	print 'Modelos Toyota: '+ cast(@v_cont_Toyota as varchar)
	print 'Total de carros: '+ cast(@v_cont_total as varchar)
	
end
go 
--fechando o bloco anônimo T-SQL


/* IF E ELSE */

declare
	@numero int = 101
begin
		if @numero % 2 = 0 
			print 'É PAR'
		else
			print 'É IMPAR'
		
		if @numero >= 5 
			print 'MAIOR OU IGUAL A 5'
		else
			print 'MENOR QUE 5'
end 
go


/* CASE */
 -- O case representa uma coluna 
begin 
	
	select 
	case 
		when montadora = 'Fiat' then  'FIAT'
		when montadora = 'Chevrolet' then 'CHEVROLET'
		when montadora = 'Ford' then  'FORD'
		else  'OUTRAS'
	end as 'INFORMAÇÕES',
	modelo,
	montadora
	from carros 
end 
go



create proc verificaNumero @p_numero int 
as
begin
		if @p_numero % 2 = 0 
			print 'É PAR'
		else
			print 'É IMPAR'
		
		if @p_numero >= 5 
			print 'MAIOR OU IGUAL A 5'
		else
			print 'MENOR QUE 5'
end 
go

exec verificaNumero 5 
go 

/* WHILE */
create proc incrementar @num int
as
declare 
@n = @num+10 
begin 
	while (@num < @n)
	begin 
		print 'valor do numero: '+ cast(@num as varchar)
		set @num=@num+1
	end
end 
go
