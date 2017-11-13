let env = {};

// Import environment variables if present (from env.js)
if(window){
	Object.assign(env, window.__env);
}

let app = angular.module(env.appName, []);

app.constant('__env', env);

const log = (...args) => {
	if (env.debugEnabled) console.log(...args);
}

log('Base module loaded');
