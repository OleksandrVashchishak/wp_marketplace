import * as React from 'react';
import { Link } from "react-router-dom";

import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import AdbIcon from '@mui/icons-material/Adb';

const NavMenu = ({ isLogin }) => {
    return (
        <>
            <AdbIcon sx={{ display: { xs: 'none', md: 'flex' }, mr: 1 }} />
            <Box sx={{ flexGrow: 1, display: { xs: 'none', md: 'flex' } }}>
                <Button sx={{ my: 2, color: 'white', display: 'block' }}  >
                    <Link to="/">All cars</Link>
                </Button>

                {isLogin && <>
                    <Button sx={{ my: 2, color: 'white', display: 'block' }}  >
                        <Link to="/add-car">Add car</Link>
                    </Button>

                    <Button sx={{ my: 2, color: 'white', display: 'block' }}  >
                        <Link to="/posts">Posts</Link>
                    </Button>

                    <Button sx={{ my: 2, color: 'white', display: 'block' }}  >
                        <Link to="/add-post">Add Post</Link>
                    </Button>

                    <Button sx={{ my: 2, color: 'white', display: 'block' }}  >
                        <Link to="/media">Media</Link>
                    </Button>

                    <Button sx={{ my: 2, color: 'white', display: 'block' }}  >
                        <Link to="/messanger">Messages</Link>
                    </Button>
                </>}
            </Box>
        </>
    );
}

export default NavMenu