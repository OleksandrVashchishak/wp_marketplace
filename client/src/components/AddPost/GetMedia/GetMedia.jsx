import axios from 'axios';
import React from "react";
import Button from '@mui/material/Button';
import CloseIcon from '@mui/icons-material/Close';
import { Link } from "react-router-dom";

const GetMedia = ({ setMedia }) => {
    const [mediaSourse, setMediaSourse] = React.useState([]);
    const [chooseMedia, setChooseMedia] = React.useState('');
    const [popup, setPopup] = React.useState(false);
    React.useEffect(() => {
        const route = `http://cars/wp-json/wp/v2/media?per_page=99`
        axios.get(route)
            .then(response => {
                setMediaSourse(response.data)
            }).catch(err => {
                console.log(err);
            })
    }, []);

    const setMediaHandler = (id, url) => {
        setMedia(id)
        setChooseMedia(url)
        setPopup(false)
    }

    return (
        <>
            <br />
            <Button onClick={() => setPopup(true)} variant="outlined">Add image  </Button>

            {chooseMedia && <div className="addpost-media-choose">
                <img src={chooseMedia} alt='img' />
            </div>}

            {popup && <div className="addpost-media">
                <Button variant="outlined"> <Link to="/media">Upload images</Link></Button>
                <br /> <br />

                <div className="close-icon" onClick={() => setPopup(false)}>
                    <CloseIcon />
                </div>
                <div className="addpost-media-wrapper">
                    {mediaSourse && mediaSourse.map(media => (
                        <img src={media.source_url} key={media.id} onClick={() => setMediaHandler(media.id, media.source_url)} alt='preview' />
                    ))}
                </div>
            </div>}
        </>
    );
}

export default GetMedia