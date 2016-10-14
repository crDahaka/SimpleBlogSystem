<?php

class PostsModel extends BaseModel
{
    /**
     * Get all posts.
     *
     * @return array
     */
    public function getAll() : array {
        $statement = self::$db->query(
            "SELECT * FROM posts ORDER BY date DESC");
        return $statement->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get post by id.
     *
     * @param int $id
     * @return array
     */
    public function getById(int $id){
        $statement = self::$db->prepare(
            "SELECT * FROM posts WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        return $result;
    }

    /**
     * Create post.
     *
     * @param string $title
     * @param string $content
     * @param int $user_id
     * @return bool
     */
    public function create(string $title, string $content, int $user_id) : bool {
        $statement = self::$db->prepare(
            "INSERT INTO posts(title, content, user_id) VALUES(?, ?, ?)");
        $statement->bind_param("ssi", $title, $content, $user_id);
        $statement->execute();
        return $statement->affected_rows == 1;
    }

    /**
     * Edit post.
     *
     * @param string $id
     * @param string $title
     * @param string $content
     * @param string $date
     * @param int $user_id
     * @return bool
     */
    public function edit(string $id, string $title, string $content,
         string $date, int $user_id) : bool {

        $statement = self::$db->prepare("UPDATE posts SET title = ?, " .
            "content = ?, date = ?, user_id = ? WHERE id = ?");
        $statement->bind_param("sssii", $title, $content, $date, $user_id, $id);
        $statement->execute();
        return $statement->affected_rows >= 0;
    }

    /**
     * Delete post by id.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool {
        $statement = self::$db->prepare(
            "DELETE FROM posts WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->affected_rows == 1;
    }
}