create database EventPass;

use EventPass;

create table Eventos (
    id int primary key auto_increment,
    nome varchar(255) not null,
    descricao text,
    data_evento datetime not null,
    abertura time not null,
    local_evento varchar(255) not null,
    capacidade_maxima int not null,
    preco_ingresso decimal(10, 2) not null,
    logo longblob not null,
    classificacao ENUM('LIVRE', '10', '12', '14', '16', '18') not null
);

create table Usuarios (
    id int primary key auto_increment,
    dataNascimento datetime not null,
    cpf varchar(11) unique not null,
    nome varchar(255) not null,
    email varchar(255) unique not null,
    senha varchar(255) not null,
    telefone varchar(15),
    endereco text,
    sexo enum ('MULHER', 'HOMEM') not null,
    perfil enum('ADMINISTRADOR', 'USUARIO') not null
);

create table Ingressos (
    id int primary key auto_increment,
    evento_id int not null,
    usuario_id int not null,
    quantidade int not null,
    data_compra datetime not null,
    tipo_ingresso enum('inteira', 'meia') not null,
    processo_ingresso enum('pendente', 'pago', 'cancelado') not null,
    foreign key (evento_id) references Eventos(id),
    foreign key (usuario_id) references Usuarios(id)
);

create table Categorias (
    id int primary key auto_increment,
    nome varchar(255) not null,
    descricao text
);

create table EventoCategoria (
    evento_id int,
    categoria_id int,
    primary key (evento_id, categoria_id),
    foreign key (evento_id) references Eventos(id),
    foreign key (categoria_id) references Categorias(id)
);

create table Pagamentos (
    id int primary key auto_increment,
    ingresso_id int unique,
    metodo_pagamento enum('cartao', 'boleto', 'pix') not null,
    valor_total decimal(10, 2) not null,
    status_pagamento enum('pendente', 'aprovado', 'recusado') not null,
    data_pagamento datetime not null,
    foreign key (ingresso_id) references Ingressos(id) 
);

insert into Eventos (nome, descricao, data_evento, abertura, local_evento, capacidade_maxima, preco_ingresso, logo, classificacao) values
('Journey Tour 2022', 'Turnê da banda Journey com clássicos do rock', '2025-08-15 15:00:00', '13:30:00', 'São Paulo-SP', 8000, 600, 'https://cdn.nsite.com.br/imgcache/494/1400x/uploads/494/journey%20e%20toto.jpg.webp', '10'),
('Foreigner Tour', 'Apresentação da banda Foreigner com seus maiores sucessos', '2025-10-20 14:30:00', '13:00:00', 'Rio de Janeiro-RJ', 7000, 550, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTRebUv9-cbgZaylYdXWoMlwXzKpeyqvP5lA&s', '18'),
('Bruno Mars Brasil', 'Show de Bruno Mars com grandes hits internacionais', '2025-11-05 20:00:00', '19:30:00', 'Belo Horizonte-MG', 10000, 950, 'https://upload.wikimedia.org/wikipedia/pt/2/21/Bruno_Mars_-_Live_in_Brazil_-_Turnê.jpg', 'LIVRE'),
('Nickelback Tour', 'Turnê da banda Nickelback com repertório completo', '2025-12-12 18:25:00', '16:45:00', 'Curitiba-PR', 6500, 620, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSyPKQ06CiGAY2MQGzwNy5KkBVjF-gkvJTx0w&s', '16');

insert into Usuarios (dataNascimento, cpf, nome, email, senha, telefone, endereco, sexo, perfil) values
('2005-01-31', '50168396890', 'Paulo Henrique de Sousa', 'paulinho@gmail.com', '1234', 'Não informado', 'Não informado', 'HOMEM', 'ADMINISTRADOR'),
('2008-02-24', '27459937800', 'Igor Soares Neves', 'igor@gmail.com', '1234', 'Não informado', 'Não informado', 'HOMEM', 'USUARIO');