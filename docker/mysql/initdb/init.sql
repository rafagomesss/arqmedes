CREATE DATABASE IF NOT EXISTS arqmedes CHARSET utf8mb4 COLLATE utf8mb4_general_ci;
USE arqmedes;

DROP TABLE IF EXISTS roles;
CREATE TABLE IF NOT EXISTS roles
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL,
    role ENUM('ADMIN', 'MANAGER', 'USER') UNIQUE NOT NULL,
    PRIMARY KEY(id)
) ENGINE = InnoDB;
INSERT INTO roles (role) VALUES ('ADMIN'), ('MANAGER'), ('USER');

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users
(
    id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT UNSIGNED,
    is_admin BOOLEAN NOT NULL DEFAULT false,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME,
    CONSTRAINT fk_users_roles
        FOREIGN KEY (role_id)
        REFERENCES roles(id),
    PRIMARY KEY(id)
) ENGINE = InnoDB;

# Os campos products.sku e categories.name, a depender do contexto poderão ser utilizados como UNIQUE
# Como não havia previsto nos requisitos, deixei os campos livres
DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador da tabela de produtos',
	name VARCHAR(255) NOT NULL COMMENT 'Nome do produto',
	sku VARCHAR(50) NOT NULL COMMENT 'Código do produto criado com uma sequência lógica entre números e caracteres para identificar um produto',
	price DECIMAL(10, 2) NOT NULL COMMENT 'Preço do produto',
	description TEXT COMMENT 'Descrições do produto. Detalhamento.',
	quantity INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Quantidade do estoque iniciado em 0',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Data em que o produto foi criado no banco, default de acordo com o date do database no servidor',
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP COMMENT 'Data em que o produto foi alterado',
    deleted_at DATETIME COMMENT 'Coluna criada para tratar soft delete. Data em que o produto foi "removido" da base',
	PRIMARY KEY (id)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS categories;
CREATE TABLE IF NOT EXISTS categories (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT 'Identificador da tabela de categorias dos produtos',
    name VARCHAR(255) NOT NULL COMMENT 'Nome da categoria que produtos poderão pertencer',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Data em que a categoria foi criada no banco, default de acordo com o date do database no servidor',
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP COMMENT 'Data em que a categoria foi alterada',
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS product_categories;
CREATE TABLE IF NOT EXISTS product_categories (
  product_id INT UNSIGNED NOT NULL COMMENT 'Identificador do produto',
  category_id INT UNSIGNED NOT NULL COMMENT 'Identificador da categoria',
  PRIMARY KEY (product_id, category_id),
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;