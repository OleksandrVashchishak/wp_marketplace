import React from "react";
import axios from 'axios';
import Button from '@mui/material/Button';
import { Link } from "react-router-dom";

const Posts = () => {
    const [posts, setPosts] = React.useState([])
    const [removed, setRemoved] = React.useState(null)
    React.useEffect(() => {
        const apiHost = 'http://cars/wp-json/wp/v2';
        axios({
            method: 'GET',
            url: apiHost + '/posts?per_page=99',
        }).then((result) => {
            setPosts(result.data)
        }).catch(function (err) {
            console.log(err);
        });
    }, [removed]);


    const removePost = (id) => {
        const apiHost = 'http://cars/wp-json/wp/v2';
        axios({
            method: 'DELETE',
            url: apiHost + `/posts/${id}`,
            headers: { "Authorization": "Bearer " + localStorage.getItem("token") },
        }).then((result) => {
            setRemoved(result.data.id)
        }).catch(function (err) {
            console.log(err);
        });
    }
    return (
        <div className="post-add-wrapper">
            <h3> Posts</h3>
            {posts && posts.map(post => (
                <div className="post" key={post.id}>
                    <div className="post__left">
                        <h5>{post.title.rendered}</h5>
                        <span>{post.status}</span>
                    </div>
                    <div className="post__right">
                        <Button variant="contained" onClick={() => removePost(post.id)}>Remove</Button>
                        <Button variant="outlined" >
                            <Link to={`/add-post?id=${post.id}`}>Edit</Link>
                        </Button>
                    </div>
                </div>
            ))}
        </div>
    );
}

export default Posts