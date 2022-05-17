import React from 'react';
import ReactDOM from 'react-dom';

export default function Users() {
    return (
        <h1>Users Section</h1>
    );
}

if (document.getElementById('users')) {
    ReactDOM.render(<Users />, document.getElementById('users'));
}