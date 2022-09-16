import axios from 'axios';
import React from "react";
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import Snackbar from '@mui/material/Snackbar';
import MuiAlert from '@mui/material/Alert';
import GetCats from './GetCats/GetCats'
import GetMedia from './GetMedia/GetMedia'
import Editor from './Editor/Editor'

const Alert = React.forwardRef(function Alert(props, ref) {
    return <MuiAlert elevation={6} ref={ref} variant="filled" {...props} />;
});

const AddPost = () => {
    const [checkedCats, setCheckedCats] = React.useState([])
    const [media, setMedia] = React.useState(null)
    const [title, setTitle] = React.useState('');
    const [slug, setSlug] = React.useState('');
    const [content, setContent] = React.useState('');
    const [open, setOpen] = React.useState(false);

    const addPost = () => {
        const apiHost = 'http://cars/wp-json/wp/v2';
        axios({
            method: 'POST',
            url: apiHost + '/posts',
            headers: { "Authorization": "Bearer " + localStorage.getItem("token") },
            params: {
                status: 'publish',
                title: title,
                content: content,
                categories: checkedCats,
                slug: slug,
                featured_media: media,
            }
        }).then(() => {
            setOpen(true);
            setContent('')
            setTitle('')
        }).catch(function (err) {
            console.log(err);
        });
    }

    const handleClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }

        setOpen(false);
    };

    const handleTitle = (value) => {
        setTitle(value)
        setSlug(value.replace(/ /g, "-"))
    }

    return (
        <div className="post-add-wrapper">
            <div className="post-df">
                <div className="post-left">
                    <TextField value={title} onChange={(e) => handleTitle(e.target.value)} label="Title" variant="outlined" margin="normal" />
                    <br />
                    <TextField value={slug} onChange={(e) => setSlug(e.target.value.replace(/ /g, "-"))} label="Slug" variant="standard" size="small" margin="normal" />
                    <br />  <br />
                    <Editor content={content} setContent={setContent} />
                    <br /><br />
                    <Button variant="contained" onClick={() => addPost()}>Add Post</Button>
                </div>
                <div className="post-right">
                    <GetCats checkedCats={checkedCats} setCheckedCats={setCheckedCats} />
                    <GetMedia setMedia={setMedia} />
                </div>
            </div>
            <Snackbar open={open} autoHideDuration={6000} onClose={handleClose}>
                <Alert onClose={handleClose} severity="success" sx={{ width: '100%' }}>
                    Post added successfully
                </Alert>
            </Snackbar>
        </div>
    );
}

export default AddPost