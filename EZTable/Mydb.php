<?php

class Mydb
{
	const USERS = 'users';
	const USERS_ID = 'users.id';
	const USERS_USERNAME = 'users.username';
	const USERS_PASSWORD = 'users.password';
	const USERS_CREATED_AT = 'users.created_at';
	/*********************************/
	const POSTS = 'posts';
	const POSTS_ID = 'posts.id';
	const POSTS_TITLE = 'posts.title';
	const POSTS_CONTENT = 'posts.content';
	const POSTS_USER_ID = 'posts.user_id';
	const POSTS_CREATED_AT = 'posts.created_at';
	/*********************************/
	const COMMENTS = 'comments';
	const COMMENTS_ID = 'comments.id';
	const COMMENTS_CONTENT = 'comments.content';
	const COMMENTS_POST_ID = 'comments.post_id';
	const COMMENTS_USER_ID = 'comments.user_id';
	const COMMENTS_CREATED_AT = 'comments.created_at';
	/*********************************/
	const NO_COLUMN = 'NoColumn';
	/*********************************/
}
