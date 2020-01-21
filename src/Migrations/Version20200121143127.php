<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200121143127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE property_options (property_id INT NOT NULL, options_id INT NOT NULL, INDEX IDX_89F8B0FF549213EC (property_id), INDEX IDX_89F8B0FF3ADB05F1 (options_id), PRIMARY KEY(property_id, options_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_options ADD CONSTRAINT FK_89F8B0FF549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_options ADD CONSTRAINT FK_89F8B0FF3ADB05F1 FOREIGN KEY (options_id) REFERENCES options (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE options_property');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE options_property (options_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_21C8AA603ADB05F1 (options_id), INDEX IDX_21C8AA60549213EC (property_id), PRIMARY KEY(options_id, property_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE options_property ADD CONSTRAINT FK_21C8AA603ADB05F1 FOREIGN KEY (options_id) REFERENCES options (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE options_property ADD CONSTRAINT FK_21C8AA60549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE property_options');
    }
}
