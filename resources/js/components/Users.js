import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import DynamicDataTable from "@langleyfoxall/react-dynamic-data-table";


export default class Users extends Component {

    constructor(props) {
        super(props);
        console.log(this.props)
      }
    render() {
        return (
            
            <div className="container">
                <DynamicDataTable 
                    rows={this.props.users}
                    alwaysShowPagination
                    className="user_table"
                    columnWidths={{
                        id: 15,
                        name: 30,
                        email:40,
                        role: 20
                    }}
                                   
                />
            </div>
        );
    }
}

if (document.getElementById('users')) {
    const props = Object.assign({}, users.dataset)    
    ReactDOM.render(<Users users={JSON.parse(props.users)} />, document.getElementById('users'));
}