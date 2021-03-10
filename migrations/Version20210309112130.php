<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309112130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '#6 Add sulg field to Categories & Article, add relation between Categories/Users, Categories/Categories, Article/Categories,Article/Users';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD users_id INT NOT NULL, ADD categories_id INT NOT NULL, ADD slug VARCHAR(255) NOT NULL, ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6667B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6667B3B43D ON article (users_id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A21214B7 ON article (categories_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6667B3B43D');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A21214B7');
        $this->addSql('DROP INDEX IDX_23A0E6667B3B43D ON article');
        $this->addSql('DROP INDEX IDX_23A0E66A21214B7 ON article');
        $this->addSql('ALTER TABLE article DROP users_id, DROP categories_id, DROP slug, DROP active');
    }
}
