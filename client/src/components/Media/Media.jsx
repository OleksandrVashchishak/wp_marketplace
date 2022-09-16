import axios from 'axios';
import React from "react";

const Media = () => {
    const [mediaSourse, setMediaSourse] = React.useState([]);
    const [imageId, setImageId] = React.useState(null);

    React.useEffect(() => {
        const route = `http://cars/wp-json/wp/v2/media?per_page=99`
        axios.get(route)
            .then(response => {
                setMediaSourse(response.data)
            }).catch(err => {
                console.log(err);
            })
    }, [imageId]);

    const toBase64 = file => new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });

    async function main(file) {
        try {
            const result = await toBase64(file);
            return result
        } catch (error) {
            console.error(error);
            return;
        }
    }

    const uploadFile = (target) => {
        const format = target.files[0].type.split('image/')[1]
        main(target.files[0]).then((value) => {
            var apiHost = 'http://cars/wp-json';
            axios({
                method: 'POST',
                url: apiHost + `/wm/v1/add_media`,
                data: {
                    hash: value,
                    format: format
                },
                headers: { 'Content-Type': `multipart/form-data`, },
            }).then((response) => {
                if (response.data) {
                    setImageId(response.data)
                }
            }).catch(function (err) {
                console.log(err);
            });
        });
    }

    return (
        <div className="media-wrapper">
            <br />
            <label className='st-label'>
                Upload
                <input className='media-wrapper-upload-file' type="file" onChange={(e) => uploadFile(e.target)} />
            </label>

            <br /><br />

            <div className="media-wrapper-imgs">
                {mediaSourse && mediaSourse.map(media => (
                    <img src={media.source_url} key={media.id} alt='preview' />
                ))}

            </div>
        </div>
    );
}

export default Media