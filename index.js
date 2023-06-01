#!/usr/bin/env node

const fs = require('fs-extra');
const wget = require('node-wget');
const extract = require('extract-zip');
const os = require('os');




const colorError = "\u001b[31m";
const colorSuccess = "\u001b[32m";
const colorInfo = "\u001b[34m";
const downloadFileName = "wordpress_" + Date().toString();
const boilerplatePath = __dirname + '/src/theme_starter_kit'

const printError = (message) => console.error(colorError, message);
const printSuccess = (message) => console.log(colorSuccess, message);
const printInfo = (message) => console.info(colorInfo, message);


var projectName, dir, themeDir;

const tempDir = os.tmpdir();

const currentDirectory = process.cwd();





init();




// Entry point of the tool
async function init() {
    fetchVariables();



}

function fetchVariables() {

    projectName = process.argv[3];
    if (projectName == null)
        return printError(
            "please enter project name, run: fcts-wp new [project-name]"
        );
    projectName = replaceAll(projectName, "-", "_");
    dir = `${projectName}-wp`;

    themeDir = currentDirectory + `/${dir}/wp-content/themes/${projectName}`;

    if (!dir)
        return printError(
            "please enter project name, run: fcts-wp new [project-name]"
        );

    createProject();

}

function createProject() {

    if (fs.existsSync(dir))
        return printError("directory exists, please choose another name");

    // create directory for the project name
    printInfo(`Creating Wordpress Project: ${dir} ......`);
    fs.mkdirSync(dir);
    printSuccess(`Directory: ${dir} created.`);

    downloadLatestWordpress();

}


async function downloadLatestWordpress() {

    try {

        printInfo("====================");
        printInfo("Downloading Latest version of Wordpress.");
        wget({ url: "http://wordpress.org/latest.zip", dest: `${tempDir}/${downloadFileName}.zip` }, function (error, response, body) {


            if (error) {
                printError(error);
            } else {

                printSuccess("Latest version of Wordpress downloaded.");
                printInfo("====================");
                unzipWordpress();

            }
        });



    } catch (err) {
        printError(err)
    }

}

async function unzipWordpress() {

    try {

        printInfo("Unzipping Wordpress.");
        await extract(`${tempDir}/${downloadFileName}.zip`, { dir: tempDir + `/${downloadFileName}`, })
        printSuccess("Unzipped Wordpress.");
        printInfo("====================");


        printInfo("Copying Wordpress to Project: " + projectName);
        copyWordpressFilesToProject();
        printSuccess("Copied Wordpress to Project: " + projectName);
        printInfo("====================");


        printInfo("Creating Wordpress Theme for Project: " + projectName);
        createTheme();
        printSuccess("Created Wordpress Theme for Project: " + projectName);
        printInfo("====================");

        printInfo("Creating Theme Boilerplate for Project: " + projectName);
        copyThemeBoilerplate();
        replaceThemeNameVariables();
        printSuccess("Created Theme Boilerplate for Project: " + projectName);
        printInfo("====================");

        printSuccess("Setup Completed");
        printInfo("====================");

    } catch (err) {
        // handle any errors
        printError(err)
    }
}

function copyWordpressFilesToProject() {

    fs.copySync(`${tempDir}/${downloadFileName}/wordpress`, `${currentDirectory}/${dir}`);

}

function createTheme() {
    // create a theme for the project

    fs.mkdirSync(themeDir);

}

function copyThemeBoilerplate() {


    try {
        fs.copySync(boilerplatePath, currentDirectory + `/${dir}/wp-content/themes/${projectName}`)

    } catch (err) {
        printError(err)
    }

}

function replaceThemeNameVariables() {

    // includes folder
    const themeIncDir = `${themeDir}/inc`;
    const themeFiles = fs.readdirSync(themeIncDir);

    for (const file of themeFiles) {
        if (file.includes('theme-name')) {
            var newFileName = file.replace('theme-name-', `${projectName}-`)
            // fs.createFile(`${themeIncDir}/${newFileName}`);
            var fileContent = fs.readFileSync(`${themeIncDir}/${file}`);
            fileContent = fileContent.toString();
            fileContent = replaceAll(fileContent, 'THEME_NAME', projectName.toUpperCase())
            fileContent = replaceAll(fileContent, 'Theme_Name', projectName.toUpperCase())
            fileContent = replaceAll(fileContent, 'theme_name', projectName.toLowerCase())
            fileContent = replaceAll(fileContent, 'theme-name', projectName.toLowerCase())

            fs.writeFileSync(`${themeIncDir}/${newFileName}`, fileContent);

            fs.unlinkSync(`${themeIncDir}/${file}`);

        }
    }

    // theme root files

    const themeRootFiles = fs.readdirSync(themeDir);

    for (const file of themeRootFiles) {

        if (fs.lstatSync(`${themeDir}/${file}`).isFile()) {

            var fileContent = fs.readFileSync(`${themeDir}/${file}`);
            fileContent = fileContent.toString();
            fileContent = replaceAll(fileContent, 'THEME_NAME', projectName.toUpperCase())
            fileContent = replaceAll(fileContent, 'Theme_Name', projectName)
            fileContent = replaceAll(fileContent, 'theme_name', projectName.toLowerCase())
            fileContent = replaceAll(fileContent, 'theme-name', projectName.toLowerCase())

            fs.writeFileSync(`${themeDir}/${file}`, fileContent);

        }
    }

    // language  files

    const themeLanguageFiles = fs.readdirSync(`${themeDir}/languages`);

    for (const file of themeLanguageFiles) {
        if (file.includes('theme-name')) {
            var fileContent = fs.readFileSync(`${themeDir}/languages/${file}`);
            var newFileName = file.replace('theme-name', `${projectName}`)
            fs.writeFileSync(`${themeDir}/languages/${newFileName}`, fileContent);

            fs.unlinkSync(`${themeDir}/languages/${file}`);

        }
    }


}


// Helper Functions

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}



















