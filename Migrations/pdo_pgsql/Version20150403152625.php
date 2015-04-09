<?php

namespace FormaLibre\InvoiceBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2015/04/03 03:26:26
 */
class Version20150403152625 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE formalibre__product (
                id SERIAL NOT NULL, 
                code VARCHAR(255) NOT NULL, 
                type VARCHAR(255) NOT NULL, 
                details TEXT DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_53C6972477153098 ON formalibre__product (code)
        ");
        $this->addSql("
            COMMENT ON COLUMN formalibre__product.details IS '(DC2Type:json_array)'
        ");
        $this->addSql("
            CREATE TABLE formalibre__order (
                id SERIAL NOT NULL, 
                product_id INT DEFAULT NULL, 
                price_solution_id INT DEFAULT NULL, 
                owner_id INT DEFAULT NULL, 
                vatAmount DOUBLE PRECISION DEFAULT NULL, 
                vatRate DOUBLE PRECISION DEFAULT NULL, 
                ipAddress VARCHAR(255) DEFAULT NULL, 
                countryCode VARCHAR(255) DEFAULT NULL, 
                vatNumber VARCHAR(255) DEFAULT NULL, 
                amount DOUBLE PRECISION DEFAULT NULL, 
                extendedData TEXT DEFAULT NULL, 
                paymentInstruction_id INT DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_62CE339EFD913E4D ON formalibre__order (paymentInstruction_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_62CE339E4584665A ON formalibre__order (product_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_62CE339E1BD2AD95 ON formalibre__order (price_solution_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_62CE339E7E3C61F9 ON formalibre__order (owner_id)
        ");
        $this->addSql("
            COMMENT ON COLUMN formalibre__order.extendedData IS '(DC2Type:json_array)'
        ");
        $this->addSql("
            CREATE TABLE formalibre__price_solution (
                id SERIAL NOT NULL, 
                product_id INT DEFAULT NULL, 
                monthDuration INT NOT NULL, 
                price DOUBLE PRECISION NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_E2B632A84584665A ON formalibre__price_solution (product_id)
        ");
        $this->addSql("
            CREATE TABLE formalibre__shared_workspace (
                id SERIAL NOT NULL, 
                owner_id INT NOT NULL, 
                product_id INT DEFAULT NULL, 
                remoteId INT NOT NULL, 
                end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, 
                maxSize VARCHAR(255) NOT NULL, 
                maxUser INT NOT NULL, 
                maxRes INT NOT NULL, 
                autoSubscribe BOOLEAN NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_1559C4C27E3C61F9 ON formalibre__shared_workspace (owner_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_1559C4C24584665A ON formalibre__shared_workspace (product_id)
        ");
        $this->addSql("
            ALTER TABLE formalibre__order 
            ADD CONSTRAINT FK_62CE339EFD913E4D FOREIGN KEY (paymentInstruction_id) 
            REFERENCES payment_instructions (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE formalibre__order 
            ADD CONSTRAINT FK_62CE339E4584665A FOREIGN KEY (product_id) 
            REFERENCES formalibre__product (id) 
            ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE formalibre__order 
            ADD CONSTRAINT FK_62CE339E1BD2AD95 FOREIGN KEY (price_solution_id) 
            REFERENCES formalibre__price_solution (id) 
            ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE formalibre__order 
            ADD CONSTRAINT FK_62CE339E7E3C61F9 FOREIGN KEY (owner_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE formalibre__price_solution 
            ADD CONSTRAINT FK_E2B632A84584665A FOREIGN KEY (product_id) 
            REFERENCES formalibre__product (id) 
            ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE formalibre__shared_workspace 
            ADD CONSTRAINT FK_1559C4C27E3C61F9 FOREIGN KEY (owner_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
        $this->addSql("
            ALTER TABLE formalibre__shared_workspace 
            ADD CONSTRAINT FK_1559C4C24584665A FOREIGN KEY (product_id) 
            REFERENCES formalibre__product (id) 
            ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE formalibre__order 
            DROP CONSTRAINT FK_62CE339E4584665A
        ");
        $this->addSql("
            ALTER TABLE formalibre__price_solution 
            DROP CONSTRAINT FK_E2B632A84584665A
        ");
        $this->addSql("
            ALTER TABLE formalibre__shared_workspace 
            DROP CONSTRAINT FK_1559C4C24584665A
        ");
        $this->addSql("
            ALTER TABLE formalibre__order 
            DROP CONSTRAINT FK_62CE339E1BD2AD95
        ");
        $this->addSql("
            DROP TABLE formalibre__product
        ");
        $this->addSql("
            DROP TABLE formalibre__order
        ");
        $this->addSql("
            DROP TABLE formalibre__price_solution
        ");
        $this->addSql("
            DROP TABLE formalibre__shared_workspace
        ");
    }
}