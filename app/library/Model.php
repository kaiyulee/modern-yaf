<?php
use Yaf\Registry;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Configuration as Conf;
use Doctrine\DBAL\DriverManager;

class Model
{
    private $db;
    private $conn;
    private $db_config;
    public static $em;

    public function __construct()
    {
    }

    public static function getEntityManager()
    {
        $isDevMode = true;
        $conf = Registry::get('mysql')->master->toArray();
        $config = Setup::createAnnotationMetadataConfiguration($conf, $isDevMode);
        EntityManager::create($conf, $config);
    }

    public function connect(array $params = [])
    {
        if (empty($params)) {
            $params = $this->db_config ?? Registry::get('mysql')->master->toArray();
        }

        $conf = new Conf();
        $this->conn = DriverManager::getConnection($params, $conf);

        return $this->conn;
    }

    public function writeServer()
    {
        $config = Registry::get('mysql')->master->toArray();
        $this->db_config = $config;

        return $this;
    }

    /**
     * Use slave server config, if $key is specified, use the specified one, otherwise
     * choose one from slaves randomly. see `database.ini` file
     *
     * @param null $key
     * @return $this
     */
    public function readServer($key = null)
    {
        $config = Registry::get('mysql')->slave->toArray();

        if (empty($key)) {
            $key = array_rand($config);
        }

        $this->db_config = $config[$key];

        return $this;
    }
}
