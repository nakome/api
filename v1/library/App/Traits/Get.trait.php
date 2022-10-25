<?php

/*
 * Declara al principio del archivo, las llamadas a las funciones respetarán
 * estrictamente los indicios de tipo (no se lanzarán a otro tipo).
 */
declare (strict_types = 1);

namespace App\Traits;

/*
 * Prevenir accesso
 */
defined('ACCESS') or die(ACCESSINFO);

/**
 * @author      Moncho Varela / Nakome <nakome@gmail.com>
 * @copyright   2020 Moncho Varela / Nakome <nakome@gmail.com>
 *
 * @version     0.0.1
 */
trait Get
{

    /**
     * GET routes.
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getData(string $dbname): void
    {
        $this->getUid($dbname);
        $this->getName($dbname);
        $this->getToken($dbname);
        $this->getAuthor($dbname);
        $this->getCategory($dbname);
        $this->getTitle($dbname);
        $this->getDescription($dbname);
        $this->getCreated($dbname);
        $this->getUpdated($dbname);
        $this->getPublicAuth($dbname);
        $this->getPublic($dbname);
        $this->getAll($dbname);
        $this->createApiResponse(); // empty response
    }

    /**
     * Create Response for uid
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getUid(string $dbname): void
    {
        // [url]api/g/[dbname]/?uid=1 with auth
        if ($this->auth() and array_key_exists('uid', $_GET)) {
            try {
                $uid = (string)trim($_GET["uid"]);
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $stmt = $pdo->prepare("SELECT * FROM {$dbname} WHERE uid=:uid");
                $stmt->execute(array(':uid' => (int)$uid));
                $output = $stmt->fetch();
                if ($output) {
                    $this->log("Get uid {$dbname}",(string) "Success get uid");
                    $this->createApiResponse(
                        $this->createSingleResponse($output)
                    );
                } else {
                    $this->log("Get uid {$dbname}",(string) "Error get uid");
                    $this->showErrorMessage(
                        $this->__languages["errotNotConsult"], [$dbname]
                    );
                }
            } catch (Exception $e) {
                $this->showErrorMessage(
                    $e->getMessage()
                );
            }
        }
    }

    /**
     * Create Response for name
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getName(string $dbname): void
    {
        // [url]api/g/[dbname]/?name=asdfae with auth
        if ($this->auth() and array_key_exists('name', $_GET)) {
            try {
                $name = (string)trim($_GET["name"]);
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $sql = "SELECT * FROM {$dbname} WHERE name=:name";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':name' => $name]);
                $output = $stmt->fetch();
                if ($output) {
                    $this->log("Get name {$dbname}",(string) "Success get name");
                    $this->createApiResponse(
                        $this->createSingleResponse($output)
                    );
                } else {
                    $this->log("Get name {$dbname}",(string) "Error get name");
                    $this->showErrorMessage(
                        $this->__languages["errotNotConsult"], [$dbname]
                    );
                }
            } catch (Exception $e) {
                $this->showErrorMessage(
                    $e->getMessage()
                );
            }
        }
    }

    /**
     * Create Response for token
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getToken(string $dbname): void
    {
        // [url]api/g/[dbname]/?token=1asdfasdf with auth
        if ($this->auth() and array_key_exists('token', $_GET)) {
            try {
                $token = (string)trim(urldecode($_GET["token"]));
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $stmt = $pdo->prepare("SELECT * FROM {$dbname} WHERE token=:token");
                $stmt->execute([':token' => $token]);
                $output = $stmt->fetch();
                if ($output) {
                    $this->log("Get token {$dbname}",(string) "Success get token");
                    $this->createApiResponse(
                        $this->createSingleResponse($output)
                    );
                } else {
                    $this->log("Get token {$dbname}",(string) "Error get token");
                    $this->showErrorMessage(
                        $this->__languages["errotNotConsult"], [$dbname]
                    );
                }
            } catch (Exception $e) {
                $this->showErrorMessage(
                    $e->getMessage()
                );
            }
        }
    }

    /**
     * Create Response for author
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getAuthor(string $dbname): void
    {
        // [url]api/g/[dbname]/?author=snippet with auth
        if ($this->auth() and array_key_exists('author', $_GET)) {
            try {
                $author = (string)trim(urldecode($_GET["author"]));
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : 5;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : 0;
                // connect database
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $stmt = $pdo->prepare("SELECT * FROM {$dbname} WHERE author LIKE '%{$author}%' ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}");
                $stmt->execute();
                $output = $stmt->fetchAll();
                if ($output) {
                    $this->log("Get author {$dbname}",(string) "Success get author");
                    $this->createApiResponse(
                        $this->createFullResponse($output)
                    );
                } else {
                    $this->log("Get author {$dbname}",(string) "Error get author");
                    $this->showErrorMessage(
                        $this->format(
                            $this->__languages["errotNotConsult"],
                            [$dbname]
                        )
                    );
                }
            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }

    /**
     * Create Response for category
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getCategory(string $dbname): void
    {
        // [url]api/g/[dbname]/?category=snippet with auth
        if ($this->auth() and array_key_exists('category', $_GET)) {
            try {
                $category = (string)trim(urldecode($_GET["category"]));
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : 100;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : 0;
                // connect database
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $sql = "SELECT * FROM {$dbname} WHERE category=:category ORDER BY created DESC LIMIT :limit OFFSET :offset";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':category' => ucfirst($category),':limit'=>$limit,':offset' => $offset));
                $output = $stmt->fetchAll();
                if ($output) {
                    $this->log("Get category {$dbname}",(string) "Success get category");
                    $this->createApiResponse(
                        $this->createFullResponse($output)
                    );
                } else {
                    $this->log("Get category {$dbname}",(string) "Error get category");
                    $this->showErrorMessage(
                        $this->format(
                            $this->__languages["errotNotConsult"], [$dbname]
                        )
                    );
                }
            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }

    /**
     * Create Response for title
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getTitle(string $dbname): void
    {
        // [url]api/g/[dbname]/?title=abc with auth
        if ($this->auth() and array_key_exists('title', $_GET)) {
            try {
                $title = (string)urldecode($_GET["title"]);
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : 5;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : 0;
                // connect database
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $sql = "SELECT * FROM {$dbname} WHERE title LIKE '%{$title}%' ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $output = $stmt->fetchAll();
                if ($output) {
                    $this->log("Get title {$dbname}",(string) "Success get title");
                    $this->createApiResponse(
                        $this->createFullResponse($output)
                    );
                } else {
                    $this->log("Get title {$dbname}",(string) "Error get title");
                    $this->showErrorMessage($this->__languages["errotNotConsult"], [$dbname]);
                }
            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }

    /**
     * Create Response for description
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getDescription(string $dbname): void
    {
        // [url]api/g/[dbname]/?description=abc with auth
        if ($this->auth() and array_key_exists('description', $_GET)) {
            try {
                $description = (string)urldecode($_GET["description"]);
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : 5;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : 0;
                // connect database
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $sql = "SELECT * FROM {$dbname} WHERE description LIKE '%{$description}%' ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $output = $stmt->fetchAll();
                if ($output) {
                    $this->log("Get description {$dbname}",(string) "Success get description");
                    $this->createApiResponse(
                        $this->createFullResponse($output)
                    );
                } else {
                    $this->log("Get description {$dbname}",(string) "Error get description");
                    $this->showErrorMessage(
                        $this->__languages["errotNotConsult"], [$dbname]
                    );
                }
            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }

    /**
     * Create Response for created
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getCreated(string $dbname): void
    {
        // [url]api/g/[dbname]/?created=2021 with auth
        if ($this->auth() and array_key_exists('created', $_GET)) {
            try {
                $created = (string)urldecode($_GET["created"]);
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : 5;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : 0;
                // connect database
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $sql = "SELECT * FROM {$dbname} WHERE created LIKE '%{$created}%' ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $output = $stmt->fetchAll();
                if ($output) {
                    $this->log("Get created {$dbname}",(string) "Success get created");
                    $this->createApiResponse(
                        $this->createFullResponse($output)
                    );
                } else {
                    $this->log("Get created {$dbname}",(string) "Error get created");
                    $this->showErrorMessage($this->__languages["errotNotConsult"], [$dbname]);
                }
            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }

    /**
     * Create Response for updated
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getUpdated(string $dbname): void
    {
        // [url]api/g/[dbname]/?updated=2021 with auth
        if ($this->auth() and array_key_exists('updated', $_GET)) {
            try {
                $updated = (string)urldecode($_GET["updated"]);
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : 5;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : 0;
                // connect database
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                $sql = "SELECT * FROM {$dbname} WHERE updated LIKE '%{$updated}%' ORDER BY updated DESC LIMIT {$limit} OFFSET {$offset}";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $output = $stmt->fetchAll();
                if ($output) {
                    $this->log("Get updated {$dbname}",(string) "Success get updated");
                    $this->createApiResponse(
                        $this->createFullResponse($output)
                    );
                } else {
                    $this->log("Get updated {$dbname}",(string) "Error get updated");
                    $this->showErrorMessage($this->__languages["errotNotConsult"], [$dbname]);
                }
            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }

    /**
     * Create Response for public
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getPublicAuth(string $dbname): void
    {
        // [url]api/g/[dbname]/?public=1
        if ($this->auth() and array_key_exists('public', $_GET)) {
            try {
                $public = (isset($_GET["public"])) ? (int)urldecode($_GET["public"]) : (int) 0;
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : 0;
                // connect database
                $pdo = $this->dbConnect();

                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);

                $query = "SELECT * FROM {$dbname} WHERE public={$public} ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $output = $stmt->fetchAll();
                if ($output) {
                    $this->log("Get auth public {$dbname}",(string) "Success get public");
                    $this->createApiResponse(
                        $this->createFullResponse($output)
                    );
                } else {
                    $this->log("Get auth public {$dbname}",(string) "Error get public");
                    $this->showErrorMessage(
                        $this->format($this->__languages["errotNotConsult"], [$dbname])
                    );
                }

            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }

    /**
     * Create Response for public
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getPublic(string $dbname): void
    {
        // [url]api/g/[dbname]/?public=1
        if (array_key_exists('public', $_GET)) {
            try {
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : 0;
                // connect database
                $pdo = $this->dbConnect();

                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);

                $query = "SELECT * FROM {$dbname} WHERE public=1 ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $output = $stmt->fetchAll();
                if ($output) {
                    $this->log("Get public {$dbname}",(string) "Success get public");
                    $this->createApiResponse(
                        $this->createFullResponse($output)
                    );
                } else {
                    $this->log("Get public {$dbname}",(string) "Error get public");
                    $this->showErrorMessage(
                        $this->format($this->__languages["errotNotConsult"], [$dbname])
                    );
                }

            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }

    /**
     * Create Response for all
     *
     * @param string $dbname
     *
     * @return void
     */
    public function getAll(string $dbname): void
    {
        // [url]api/g/[dbname]/?all=1
        if ($this->auth() and array_key_exists('all', $_GET)) {
            try {
                $limit = (isset($_GET["limit"])) ? (string)urldecode($_GET["limit"]) : 15;
                $offset = (isset($_GET["offset"])) ? (string)urldecode($_GET["offset"]) : 0;
                // connect database
                $pdo = $this->dbConnect();

                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);

                $query = "SELECT * FROM {$dbname} ORDER BY created DESC LIMIT {$limit} OFFSET {$offset}";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $output = $stmt->fetchAll();
                if ($output) {
                    $this->log("Get all {$dbname}",(string) "Success get all");
                    $this->createApiResponse(
                        $this->createFullResponse($output)
                    );
                } else {
                    $this->log("Get all {$dbname}",(string) "Error get all");
                    $this->showErrorMessage(
                        $this->format($this->__languages["errotNotConsult"], [$dbname])
                    );
                }

            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }

    /**
     * Create Response for all
     *
     * @param string $dbname
     *
     * @return void
     */
    public function filterData(string $dbname): void
    {
        // [url]api/g/[dbname]/?filter=title
        if ($this->auth() and array_key_exists('filter', $_GET)) {
            try {
                $filter = (string)urldecode($_GET["filter"]);
                // connect database
                $pdo = $this->dbConnect();
                // if table not exists show message
                $this->checkTableNotExists($pdo, $dbname);
                if (
                    $filter !== 'content' ||
                    $filter !== 'uid' ||
                    $filter !== 'token' ||
                    $filter !== 'public'
                ) {
                    $sql = "SELECT DISTINCT {$filter} FROM {$dbname}";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $output = $stmt->fetchAll();
                    if ($output) {
                        $this->log("Filter data {$dbname}",(string) "Success filter data");
                        $this->createApiResponse(
                            $this->createFilterResponse($filter, $output)
                        );
                    } else {
                        $this->log("Filter data {$dbname}",(string) "Error filter data");
                        $this->showErrorMessage(
                            $this->format(
                                $this->__languages["errotNotConsult"], [$dbname]
                            )
                        );
                    }
                } else {
                    $this->log("Filter data {$dbname}",(string) "Success filter data");
                    $this->showErrorMessage(
                        $this->format(
                            $this->__languages["errotNotConsult"], [$dbname]
                        )
                    );
                }
            } catch (Exception $e) {
                $this->showErrorMessage($e->getMessage());
            }
        }
    }
}
