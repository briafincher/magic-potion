import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
// import FlashMessage from 'react-flash-message';

// import Header from './Header';
import OrderForm from './OrderForm';

// function Example() {
//     return (
//         <div className="container">
//             <div className="row justify-content-center">
//                 <div className="col-md-8">
//                     <div className="card">
//                         <div className="card-header">Example Component</div>

//                         <div className="card-body">I'm an example component!</div>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     );
// }

// export default Example;

// if (document.getElementById('example')) {
//     ReactDOM.render(<Example />, document.getElementById('example'));
// }

class App extends Component {
    render() {
        return (
            // <FlashMessage duration={5000} persistOnHover={true}>
            //   <p>Message</p>
            // </FlashMessage>;
            
            <div>
                <BrowserRouter>
                    <div>
                        <Switch>
                            <Route exact path="/" component={OrderForm} />
                        </Switch>
                    </div>
                </BrowserRouter>
            </div>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('app'));
