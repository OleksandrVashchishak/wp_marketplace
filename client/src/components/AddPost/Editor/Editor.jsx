import React from "react";
import { Editor as EditorContent } from '@tinymce/tinymce-react';

const Editor = ({ setContent }) => {
    const editorRef = React.useRef(null);
  
    const handleContent = () => {
        if (editorRef.current) {
            setContent(editorRef.current.getContent())
        }
    }

    return (
        <div className="login-wrapper">
            <EditorContent
                onSelectionChange={() => handleContent()}
                onInit={(evt, editor) => editorRef.current = editor}
                init={{
                    height: 500,
                    menubar: true,
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                    ],
                    toolbar: 'undo redo | blocks | ' +
                        'bold italic forecolor | alignleft aligncenter ' +
                        'alignright alignjustify | bullist numlist outdent indent | ' +
                        'removeformat | help',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                }}
            />
        </div>
    );
}

export default Editor