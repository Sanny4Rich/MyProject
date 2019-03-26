<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190325143739 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_item ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_52EA1F094584665A ON order_item (product_id)');
        $this->addSql('ALTER TABLE attribute_values DROP FOREIGN KEY FK_184662BC6C8A81A9');
        $this->addSql('DROP INDEX IDX_184662BC6C8A81A9 ON attribute_values');
        $this->addSql('ALTER TABLE attribute_values CHANGE products_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE attribute_values ADD CONSTRAINT FK_184662BC4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_184662BC4584665A ON attribute_values (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attribute_values DROP FOREIGN KEY FK_184662BC4584665A');
        $this->addSql('DROP INDEX IDX_184662BC4584665A ON attribute_values');
        $this->addSql('ALTER TABLE attribute_values CHANGE product_id products_id INT NOT NULL');
        $this->addSql('ALTER TABLE attribute_values ADD CONSTRAINT FK_184662BC6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_184662BC6C8A81A9 ON attribute_values (products_id)');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094584665A');
        $this->addSql('DROP INDEX IDX_52EA1F094584665A ON order_item');
        $this->addSql('ALTER TABLE order_item DROP product_id');
    }
}
