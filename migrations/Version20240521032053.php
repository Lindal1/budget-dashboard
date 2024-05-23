<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521032053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plan_value (month INT NOT NULL, year INT NOT NULL, plan CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', category CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', value INT NOT NULL, INDEX IDX_4ED11DC8DD5A5B7D (plan), INDEX IDX_4ED11DC864C19C1 (category), PRIMARY KEY(plan, category, month, year)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plan_value ADD CONSTRAINT FK_4ED11DC8DD5A5B7D FOREIGN KEY (plan) REFERENCES plan (uuid)');
        $this->addSql('ALTER TABLE plan_value ADD CONSTRAINT FK_4ED11DC864C19C1 FOREIGN KEY (category) REFERENCES category (uuid)');
        $this->addSql('ALTER TABLE category CHANGE user user CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C18D93D649 FOREIGN KEY (user) REFERENCES user (uuid)');
        $this->addSql('CREATE INDEX IDX_64C19C18D93D649 ON category (user)');
        $this->addSql('ALTER TABLE plan CHANGE user user CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7D8D93D649 FOREIGN KEY (user) REFERENCES user (uuid)');
        $this->addSql('CREATE INDEX IDX_DD5A5B7D8D93D649 ON plan (user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plan_value DROP FOREIGN KEY FK_4ED11DC8DD5A5B7D');
        $this->addSql('ALTER TABLE plan_value DROP FOREIGN KEY FK_4ED11DC864C19C1');
        $this->addSql('DROP TABLE plan_value');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C18D93D649');
        $this->addSql('DROP INDEX IDX_64C19C18D93D649 ON category');
        $this->addSql('ALTER TABLE category CHANGE user user CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7D8D93D649');
        $this->addSql('DROP INDEX IDX_DD5A5B7D8D93D649 ON plan');
        $this->addSql('ALTER TABLE plan CHANGE user user CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
    }
}
