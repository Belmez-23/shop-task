<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421144044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE good (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE order_list (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, paid_at DATETIME DEFAULT NULL, refunded_at DATETIME DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE order_goods_list (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, good_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_C4FA1ECF1CF98C70 (good_id), INDEX IDX_C4FA1ECF8D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_list ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_goods_list ADD CONSTRAINT FK_C4FA1ECF1CF98C70 FOREIGN KEY (good_id) REFERENCES good (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_goods_list ADD CONSTRAINT FK_C4FA1ECF8D9F6D38 FOREIGN KEY (order_id) REFERENCES order_list (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_list DROP FOREIGN KEY FK_F5299398A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_goods_list DROP FOREIGN KEY FK_C4FA1ECF1CF98C70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_goods_list DROP FOREIGN KEY FK_C4FA1ECF8D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE good
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE order_list
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE order_goods_list
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
