// TODO comme le fichier UtilisateurManager.php


+ function add($club) INSERT INTO clubs (..., ..., ...) VALUES (:..., :..., :...)
+ function update($id)
+ function delete($id)
+ function getOne($id) SELECT * FROM clubs WHERE id = :id
+ function getAll() => SELECT * FROM clubs