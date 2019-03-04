create database oficina;

use oficina;

create table cliente(
	
	idCliente int primary key auto_increment,
	nome varchar(10) not null,
	id_Carro int unique


);

create table marca(

	idMarca int primary key auto_increment,
	nome varchar(30) not null unique
	
);

create table modelo(
	
	idModelo int primary key auto_increment,
	nome varchar(30) not null unique,
	id_Marca int

);

create table carro(
	
	idCarro int primary key auto_increment,
	vin varchar(5) unique,
	id_Modelo int

);

create table cor(
	
	idCor int primary key auto_increment,
	nome varchar(30) not null unique

);

create table carro_cor(
	
	id_Carro int,
	id_Cor int,
	primary key(id_Carro,id_Cor)
	
);

create table servico(

	idServico int primary key auto_increment,
	nome varchar(20) not null,
	preco int(5) not null,
	id_Carro int,
	id_Cliente int

);

create table telefone(
	
	idTelefone int primary key auto_increment,
	tipo enum('cel','res') not null,
	numero varchar(10) not null,
	id_Cliente int not null	

);

/* Constraints ( Regras ) */

alter table modelo 
add constraint fk_modelo_marca
foreign key (id_Marca)
references marca(idMarca);

alter table carro 
add constraint fk_carro_modelo
foreign key (id_Modelo)
references modelo(idModelo);

alter table carro_cor
add constraint fk_carro
foreign key (id_Carro)
references carro(idCarro);

alter table carro_cor
add constraint fk_cor
foreign key (id_Cor)
references cor(idCor);

alter table servico
add constraint fk_servico_carro 
foreign key (id_Carro)
references carro(idCarro);

alter table servico
add constraint fk_servico_cliente
foreign key (id_Cliente)
references cliente(idCliente);

alter table telefone
add constraint fk_telefone_cliente
foreign key (id_Cliente)
references cliente(idCliente);

/* Inserts */

--Marca
insert into marca (nome) values ('Fiat');
insert into marca (nome) values ('VolksWagen');

--Modelo
insert into modelo(nome,id_Marca) values ('Uno',1);
insert into modelo(nome,id_Marca) values ('Palio',1);
insert into modelo(nome,id_Marca) values ('Gol',2);

--Carro
insert into Carro (vin,id_modelo) values ('13ACF',1);
insert into Carro (vin,id_modelo) values ('26BDG',2);
insert into Carro (vin,id_modelo) values ('39CEH',3);

--Cor
insert into cor(nome) values ('Verde');
insert into cor(nome) values ('Vermelho');
insert into cor(nome) values ('Branco');


--Carro_Cor
insert into carro_cor(id_Carro,id_Cor) values (1,1);
insert into carro_cor(id_Carro,id_Cor) values (2,2);
insert into carro_cor(id_Carro,id_Cor) values (3,3);


--Cliente
insert into cliente(nome,id_Carro) values ('Heitor',1);
insert into cliente(nome,id_Carro) values ('Arthur',2);
insert into cliente(nome,id_Carro) values ('Hector',3);

--Servico
insert into servico(nome,preco,id_Carro,id_Cliente) values ('Troca de Oleo','110',1,1);
insert into servico(nome,preco,id_Carro,id_Cliente) values ('Ajuste Suspensao','180',2,2);
insert into servico(nome,preco,id_Carro,id_Cliente) values ('Troca Escapamento','130',3,3);

--Telefone 
insert into telefone(tipo,numero,id_Cliente) values ('cel',971487330,1);
insert into telefone(tipo,numero,id_Cliente) values ('cel',996584702,2);
insert into telefone(tipo,numero,id_Cliente) values ('cel',25674530,3);
	
	
		

/* Query */
create procedure showData()
begin
	select 	c.nome as "Cliente",
			tel.numero as "Telefone", 
			modl.nome as "Modelo", 
			mar.nome as "Marca" ,
			car.vin as "Chassi",
			cr.nome as "Cor" ,
			s.nome as "Servico", 
			s.preco as "Preco"
			from cliente c
			inner join telefone tel 
			on c.idCliente = tel.id_Cliente
			inner join carro car 
			on car.idCarro = c.id_Carro
			inner join modelo modl
			on modl.idModelo  = car.id_Modelo
			inner join marca mar 
			on modl.id_Marca = mar.idMarca
			inner join carro_cor c_c		
			on c_c.id_Carro = car.idCarro
			inner join cor cr
			on cr.idCor = c_c.id_Cor
			inner join servico s
			on s.id_Carro = car.idCarro;
end
$

		
		

