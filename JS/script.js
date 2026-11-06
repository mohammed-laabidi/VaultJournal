const btnClose = document.getElementById("btnClose");
const title = document.getElementById("inpTitle");
const description = document.getElementById("description");
const btnSave = document.getElementById("btnSave");
const inpSearch = document.getElementById("inpSearch");
const entriesContainer = document.getElementById("entries");
let modeSearch;
let arrSearch;



const openBoxNewEntry = () => box_newEntry.style.cssText = "animation: scale 0.5s forwards;"

const closeBoxNewEntry = () => {
    box_newEntry.style.cssText = "display:none;";
    //remove attr data-identry after update
    btnSave.removeAttribute("data-identry")
}

// Clear the fields in the New Entry form
const viderInputs = () => { title.value = ""; description.value = ""; }

// hidden box new Entry when click the close button 
btnClose.addEventListener("click", closeBoxNewEntry)
//get all entries by idUser sous form array
async function getEntriesByidUser() {
    const res = await fetch(`./api.php?action=show`)
    const contentType = res.headers.get("content-type")
    const result = await res.json();

        return result;
    
}

// Create and display all entries inside the entries container
async function CreateBoxsEntries(Entries) {

    //Clear all entries before adding new entries
    entriesContainer.textContent = ""

    Entries.forEach(entry => {
        // Create HTML elements
        div = document.createElement("div");
        p = document.createElement("p");
        h2 = document.createElement("h2");
        iconDelete = document.createElement("i");

        // Add CSS classes
        div.classList.add("entry");
        iconDelete.classList.add("fa-solid");
        iconDelete.classList.add("fa-trash-can");
        iconDelete.classList.add("iconDelete");

        // Add event listeners
        div.addEventListener("click", getEntryById)
        iconDelete.addEventListener("click", deleteEntryById)


        //add attr data-id and value is idEntry  
        div.setAttribute("data-id", entry["id"]);

        p.textContent = entry["date_creation"];
        h2.textContent = entry["title"];

        //Append elements in entry box
        div.append(p);
        div.append(h2);
        div.append(iconDelete);

        // Append the entry box to the entries container
        entriesContainer.append(div);

    })
}

// Fetch all user entries from the database and display them.
// If no entries exist, show a message with a button to create a new entry.
async function displayDataFromDB(params) {

    // Get all entries belonging to the current user
    const Entries = await getEntriesByidUser();
  
    //check if the user has no entries
    if(Array.isArray(Entries) && Entries.length === 0){
        
        // Clear the container
        entriesContainer.textContent = ""

         // Display a message inviting the user to create a new entry
        entriesContainer.innerHTML = `
            <p id="addEntryMessage">
                Pour crée un entrey click sur  
                <button class="btnNew" onclick="showNewEntryForm()"> New Entry</button>
            </p>
        `
    }

    //display all entries
    else CreateBoxsEntries(Entries);

}

function showNewEntryForm() {
    openBoxNewEntry();
    viderInputs();
}



async function saveEntryByIdUser() {

    if (title.value !== "" && description.value !== "") {
        if (title.value.length <= 30) {
            //encodeURIComponent prevents special characters (like &, ?, spaces) from breaking the URL structure.
            const encodeTitle = encodeURIComponent(title.value);
            const encodedescription = encodeURIComponent(description.value);

            //send title and description to api
            await fetch(`./api.php?action=add&title=${encodeTitle}&description=${encodedescription}`)

        } else alert("please don't depassé 30 caractére")

    } else alert("please full all Inputs ")



}


//get entry by idEntry from database
async function getEntryById(event) {

    //get idEntry from boxEntry we the clicked on
    const idEntry = event.currentTarget.dataset.id;

    // Get all entries belonging to the current user
    const Entries = await getEntriesByidUser();

    //search entry by idEntry 
    const Entry = Entries.filter(ele => {
        return ele["id"] == idEntry;
    });


    openBoxNewEntry()

    title.value = Entry[0]["title"];
    description.value = Entry[0]["description"]

    //add l'attr data-idEntry and value idEntry
    btnSave.setAttribute("data-idEntry", idEntry)

}

// update Entry By Id Entry
async function updateEntryById(event) {
    // Get id Entry from btnSave
    const idEntry = btnSave.dataset.identry;
    const newTitle = title.value;
    const newDescription = description.value;

    // Send the updated entry data to the server
    // and update the corresponding record in the database.
    await fetch(`./api.php?action=update&idEntry=${idEntry}&newTitle=${newTitle}&newDescription=${newDescription}`);
}

async function deleteEntryById(event) {
    // Prevent the click event from reaching the parent element
    event.stopPropagation()

    // Get the entry id from the parent element
    const parent = event.currentTarget.parentElement;
    const idEntry = parent.dataset.id;

    //send request to delete entry from database
    await fetch(`./api.php?action=delete&idEntry=${idEntry}`)

    // Refresh search results if a search is active
    if(inpSearch.value !== ""){
        const Entries = await getEntriesByidUser();
        search(Entries);
    }

    // Otherwise, reload all entries
    else displayDataFromDB()
}

function ChoisirModeSearch(idBtn) {
    if (idBtn === "SearchByT") {

        inpSearch.placeholder = "Search By Title..."

        modeSearch = "title"
    } else {

        inpSearch.placeholder = "Search By Date...";

        modeSearch = "Date";
    }

    //delete attr readonly
    inpSearch.removeAttribute("readonly");

}

function checkReadOnly() {
    //check input do you have attr readonly
    if (inpSearch.hasAttribute("readonly")) alert("please choisi le type search");

    //remove eventlistener en cas l user choisi type search
    else inpSearch.removeEventListener("click", checkReadOnly);
}

function search(Entries) {

    // Filter entries based on the selected search mode
    if (modeSearch === "title") {

        // Search by title
        arrSearch = Entries.filter((entry) => {
            return entry["title"].includes(inpSearch.value);
        });

    } else {

        // Search by creation date
        arrSearch = Entries.filter((entry) => {
            return entry["date_creation"].includes(inpSearch.value);
        });
    }

    // Display matching entries or show a "no results" message
    (arrSearch && arrSearch.length > 0)
        ? CreateBoxsEntries(arrSearch)
        : entriesContainer.innerHTML = "<p id='searchMessage'>No results found</p>";
}

async function app() {

    //get all entries by idUser sous form array
    const Entries = await getEntriesByidUser()

    //check user do he have entries
    if (Entries.status && Entries.status === "error") {
        console.log(Entries.message);
        return;

    } 

    else displayDataFromDB();

    //save entry by idUser in database
    btnSave.addEventListener("click", async (event) => {
        const btn = event.target;
        if (btn.dataset.identry) await updateEntryById(event);
        else await saveEntryByIdUser(event); 

        closeBoxNewEntry();
        displayDataFromDB();
    })

    //check input do you have attr readonly
    inpSearch.addEventListener("click", checkReadOnly)

    // Search entries by title or creation date
    // and display the matching results.
    inpSearch.addEventListener("keyup",() => search(Entries))

}

app()


