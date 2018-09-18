<?php
//---------------------------------
// load /admin/faq packages
//----------------------------------
require_once "../include/view/page/admin/faqIncludeFiles.php";
require_once "../include/etc/session.php";
siteSession();

if(isAdminLoginOK())
{
    switch(getRequest("func"))
    {
        case "add_faq":
        addFaq();
        break;

        case "edit":
        editFaq(getRequest("id"));
        break;

        case "move_up":
        moveUp(getRequest("id"));
        break;

        case "move_down":
        moveDown(getRequest("id"));
        break;

        case "save_faq":
        saveFaq();
        break;

        case "delete":
        deleteFaq(getRequest("id"));
        break;

        default:
        adminFaqPage();
        break;
    }        
}
else
{
    redirect("/admin/");
}

//---------------------------------------
// Admin FAQ page
//---------------------------------------
function adminFaqPage()
{
    require_once "../include/model/AdminFaqModel.php";

    if(!($faqs = unserialize(getUserSession('FAQ_ARRAY'))))
    {
        $db   = new AdminFaqModel();
        $faqs = $db->findAll();
        setUserSession('FAQ_ARRAY', serialize($faqs));
    }

    adminFaq($faqs);
}


//---------------------------------------
// move faq order up
//---------------------------------------
function moveUp($id)
{
    require_once "../include/model/AdminFaqModel.php";

    if(!($faqs = unserialize(getUserSession('FAQ_ARRAY'))))
    {
        $db   = new AdminFaqModel();
        $faqs = $db->findAll();
        setUserSession('FAQ_ARRAY', serialize($faqs));
    }

    if($id != 0)
    {
        //-----------------------------
        // swap faqs...
        //-----------------------------
        $faq          = $faqs[$id -1];
        $faqs[$id -1] = $faqs[$id];
        $faqs[$id]    = $faq;
        //-----------------------------
        // re-insert faq...
        //-----------------------------
        setUserSession('FAQ_ARRAY', serialize($faqs));
    }
    
    adminFaqPage();
}

//---------------------------------------
// move faq order down
//---------------------------------------
function moveDown($id)
{
    require_once "../include/model/AdminFaqModel.php";

    if(!($faqs = unserialize(getUserSession('FAQ_ARRAY'))))
    {
        $db   = new AdminFaqModel();
        $faqs = $db->findAll();
        setUserSession('FAQ_ARRAY', serialize($faqs));
    }

    if($id != (count($faqs)-1))
    {
        //-----------------------------
        // swap faqs...
        //-----------------------------
        $faq          = $faqs[$id +1];
        $faqs[$id +1] = $faqs[$id];
        $faqs[$id]    = $faq;
        //-----------------------------
        // re-insert faq...
        //-----------------------------
        setUserSession('FAQ_ARRAY', serialize($faqs));
    }
    
    adminFaqPage();
}

//---------------------------------------
// save faq
//---------------------------------------
function saveFaq()
{
    require_once "../include/view/kissyface.php";
    require_once "../include/model/AdminFaqModel.php";

    $faqs = unserialize(getUserSession('FAQ_ARRAY'));
    $db   = new AdminFaqModel();
    foreach($faqs as $faq)
        $faq->faqModified = sqlNow();
    $db->updateAll($faqs);

    kissyface("FAQs Saved", "/admin/faq.php");
}

//---------------------------------------
// add a faq
//---------------------------------------
function addFaq()
{
    require_once "../include/model/AdminFaqModel.php";

    $faqs = unserialize(getUserSession('FAQ_ARRAY'));

    $faq  = new Faq();
    $faq->faqOrder    = count($faqs); 
    $faq->faqCreated  = sqlNow();
    $faq->faqModified = sqlNow();
    $faq->faqStatus   = "DRAFT";
    $faq->faqQuestion = "Question";
    $faq->faqAnswer   = "Answer";
    $db  = new AdminFaqModel();
    $faq = $db->insert2($faq);
    $faq->faqStatus   = "ACTIVE";
    $faqs[count($faqs)] = $faq;

    setUserSession('FAQ_ARRAY', serialize($faqs));

    viewEditForm($faq);
}

//---------------------------------------
// edit a faq
//---------------------------------------
function editFaq($id)
{
    require_once "../include/model/AdminFaqModel.php";

    if(getRequest('update') == 'yes')
    {        
        $faqs = unserialize(getUserSession('FAQ_ARRAY'));
        foreach($faqs as $faq)
        {
            if($faq->faqOrder==$id)
            {
                $faq->faqQuestion = getRequest('question');
                $faq->faqAnswer   = getRequest('answer');
            }
        }
        setUserSession('FAQ_ARRAY', serialize($faqs));
        adminFaq($faqs);
    }
    else
    {
        $faqs = unserialize(getUserSession('FAQ_ARRAY'));
        foreach($faqs as $faq)
        {
            if($faq->faqOrder==$id)
                break;
        }
        setUserSession('FAQ_ARRAY', serialize($faqs));

        viewEditForm($faq);
    }
}

//---------------------------------------
// delete faq
//---------------------------------------
function deleteFaq($id)
{
    require_once "../include/model/AdminFaqModel.php";

    $faqs = unserialize(getUserSession('FAQ_ARRAY'));
    foreach($faqs as $faq)
    {
        if($faq->faqOrder==$id)
            $faq->faqStatus ="DELETED";
    }
    setUserSession('FAQ_ARRAY', serialize($faqs));
    adminFaqPage();    
}


?>
