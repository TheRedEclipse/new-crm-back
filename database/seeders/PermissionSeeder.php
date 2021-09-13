<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'admin.logs', 'title' => 'Access to laravel logs' ],
            [ 'name' => 'admin.index', 'title' => 'Access to index of control page' ],
            // Control Roles
            [ 'name' => 'admin.role.index', 'title' => 'Access to roles list' ],
            [ 'name' => 'admin.role.edit', 'title' => 'Access to editable info of role' ],
            [ 'name' => 'admin.role.store', 'title' => 'Create a role' ],
            [ 'name' => 'admin.role.update', 'title' => 'Update a role' ],
            [ 'name' => 'admin.role.destroy.soft', 'title' => 'Soft delete a role' ],
            [ 'name' => 'admin.role.destroy.hard', 'title' => 'Hard delete a role' ],
            // Control Permissions
            [ 'name' => 'admin.permission.index', 'title' => 'Access to permissions list' ],
            [ 'name' => 'admin.permission.edit', 'title' => 'Access to editable info of permission' ],
            [ 'name' => 'admin.permission.store', 'title' => 'Create a permission' ],
            [ 'name' => 'admin.permission.update', 'title' => 'Update a permission' ],
            [ 'name' => 'admin.permission.destroy.soft', 'title' => 'Soft delete a permission' ],
            [ 'name' => 'admin.permission.destroy.hard', 'title' => 'Hard delete a permission' ],
            // Control Users
            [ 'name' => 'admin.user.index', 'title' => 'Access to users list' ],
            [ 'name' => 'admin.user.edit', 'title' => 'Access to editable info of user' ],
            [ 'name' => 'admin.user.store', 'title' => 'Create a user' ],
            [ 'name' => 'admin.user.update', 'title' => 'Update a user' ],
            [ 'name' => 'admin.user.destroy.soft', 'title' => 'Soft delete a user' ],
            [ 'name' => 'admin.user.destroy.hard', 'title' => 'Hard delete a user' ],
            // Contacts
            [ 'name' => 'contact.index', 'title' => 'Access to lists of contacts' ],
            [ 'name' => 'contact.edit', 'title' => 'Access to editable info of contact' ],
            [ 'name' => 'contact.store', 'title' => 'Create a contact' ],
            [ 'name' => 'contact.update', 'title' => 'Update a contact' ],
            [ 'name' => 'contact.destroy.soft', 'title' => 'Soft delete a contact' ],
            [ 'name' => 'contact.destroy.hard', 'title' => 'Hard delete a contact' ],
            // Leads
            [ 'name' => 'lead.index', 'title' => 'Access to lists of leads' ],
            [ 'name' => 'lead.edit', 'title' => 'Access to editable info of lead' ],
            [ 'name' => 'lead.store', 'title' => 'Create a lead' ],
            [ 'name' => 'lead.store.other', 'title' => 'Create a lead' ],
            [ 'name' => 'lead.update', 'title' => 'Update a lead' ],
            [ 'name' => 'lead.destroy.soft', 'title' => 'Soft delete a lead' ],
            [ 'name' => 'lead.destroy.hard', 'title' => 'Hard delete a lead' ],
            [ 'name' => 'lead.show.by_user.own', 'title' => 'Access to info about lead by own user id' ],
            [ 'name' => 'lead.show.by_user.all', 'title' => 'Access to info about lead by any user id' ],
            // Notes
            [ 'name' => 'note.index', 'title' => 'Access to lists of notes' ],
            [ 'name' => 'note.edit', 'title' => 'Access to editable info of note' ],
            [ 'name' => 'note.store', 'title' => 'Create a note' ],
            [ 'name' => 'note.update', 'title' => 'Update a note' ],
            [ 'name' => 'note.destroy.soft', 'title' => 'Soft delete a note' ],
            [ 'name' => 'note.destroy.hard', 'title' => 'Hard delete a note' ],
            // Tasks
            [ 'name' => 'task.index', 'title' => 'Access to lists of tasks' ],
            [ 'name' => 'task.edit', 'title' => 'Access to editable info of task' ],
            [ 'name' => 'task.store', 'title' => 'Create a task' ],
            [ 'name' => 'task.update', 'title' => 'Update a task' ],
            [ 'name' => 'task.destroy.soft', 'title' => 'Soft delete a task' ],
            [ 'name' => 'task.destroy.hard', 'title' => 'Hard delete a task' ],
            // Questions
            [ 'name' => 'question.index', 'title' => 'Access to lists of questions' ],
            [ 'name' => 'question.edit', 'title' => 'Access to editable info of question' ],
            [ 'name' => 'question.store', 'title' => 'Create a question' ],
            [ 'name' => 'question.update', 'title' => 'Update a question' ],
            [ 'name' => 'question.destroy.soft', 'title' => 'Soft delete a question' ],
            [ 'name' => 'question.destroy.hard', 'title' => 'Hard delete a question' ],
            // Emails
            [ 'name' => 'email.index', 'title' => 'Access to lists of emails' ],
            [ 'name' => 'email.edit', 'title' => 'Access to editable info of email' ],
            [ 'name' => 'email.store', 'title' => 'Create a email' ],
            [ 'name' => 'email.update', 'title' => 'Update a email' ],
            [ 'name' => 'email.destroy.soft', 'title' => 'Soft delete a email' ],
            [ 'name' => 'email.destroy.hard', 'title' => 'Hard delete a email' ],
            // Dynamic content
            [ 'name' => 'image.load', 'title' => 'Access to loading images' ],
            // Attachments
            [ 'name' => 'attachment.index', 'title' => 'Access to lists of attachments' ],
            [ 'name' => 'attachment.edit', 'title' => 'Access to editable info of attachment' ],
            [ 'name' => 'attachment.store', 'title' => 'Create an attachment' ],
            [ 'name' => 'attachment.update', 'title' => 'Update an attachment' ],
            [ 'name' => 'attachment.destroy.soft', 'title' => 'Soft delete an attachment' ],
            [ 'name' => 'attachment.destroy.hard', 'title' => 'Hard delete an attachment' ],
            // Requests
            [ 'name' => 'request.index', 'title' => 'Access to lists of requests' ],
            [ 'name' => 'request.edit', 'title' => 'Access to editable info of request' ],
            [ 'name' => 'request.store', 'title' => 'Create a request' ],
            [ 'name' => 'request.update', 'title' => 'Update a request' ],
            [ 'name' => 'request.destroy.soft', 'title' => 'Soft delete a request' ],
            [ 'name' => 'request.destroy.hard', 'title' => 'Hard delete a request' ],
            // Workers
            [ 'name' => 'worker.index', 'title' => 'Access to lists of workers' ],
            // Admin Advantage
            [ 'name' => 'admin.advantage.index', 'title' => 'Access to lists of advantages' ],
            [ 'name' => 'admin.advantage.edit', 'title' => 'Access to editable info of advantage' ],
            [ 'name' => 'admin.advantage.store', 'title' => 'Create an advantage' ],
            [ 'name' => 'admin.advantage.update', 'title' => 'Update an advantage' ],
            [ 'name' => 'admin.advantage.destroy.soft', 'title' => 'Soft delete an advantage' ],
            [ 'name' => 'admin.advantage.destroy.hard', 'title' => 'Hard delete an advantage' ],
            // Admin Contact Addresses
            [ 'name' => 'admin.contact_address.index', 'title' => 'Access to lists of addresses' ],
            [ 'name' => 'admin.contact_address.edit', 'title' => 'Access to editable info of address' ],
            [ 'name' => 'admin.contact_address.store', 'title' => 'Create an address' ],
            [ 'name' => 'admin.contact_address.update', 'title' => 'Update an address' ],
            [ 'name' => 'admin.contact_address.destroy.soft', 'title' => 'Soft delete an address' ],
            [ 'name' => 'admin.contact_address.destroy.hard', 'title' => 'Hard delete an address' ],
            // Admin Contact Socials
            [ 'name' => 'admin.social.index', 'title' => 'Access to lists of socials' ],
            [ 'name' => 'admin.social.edit', 'title' => 'Access to editable info of social' ],
            [ 'name' => 'admin.social.store', 'title' => 'Create a social' ],
            [ 'name' => 'admin.social.update', 'title' => 'Update a social' ],
            [ 'name' => 'admin.social.destroy.soft', 'title' => 'Soft delete a social' ],
            [ 'name' => 'admin.social.destroy.hard', 'title' => 'Hard delete a social' ],
            // Admin Materials
            [ 'name' => 'admin.material.index', 'title' => 'Access to lists of materials' ],
            [ 'name' => 'admin.material.edit', 'title' => 'Access to editable info of material' ],
            [ 'name' => 'admin.material.store', 'title' => 'Create a material' ],
            [ 'name' => 'admin.material.update', 'title' => 'Update a material' ],
            [ 'name' => 'admin.material.destroy.soft', 'title' => 'Soft delete a material' ],
            [ 'name' => 'admin.material.destroy.hard', 'title' => 'Hard delete a material' ],
            // Admin Pages
            [ 'name' => 'admin.page.index', 'title' => 'Access to lists of pages' ],
            [ 'name' => 'admin.page.edit', 'title' => 'Access to editable info of page' ],
            [ 'name' => 'admin.page.store', 'title' => 'Create a page' ],
            [ 'name' => 'admin.page.update', 'title' => 'Update a page' ],
            [ 'name' => 'admin.page.destroy.soft', 'title' => 'Soft delete a page' ],
            [ 'name' => 'admin.page.destroy.hard', 'title' => 'Hard delete a page' ],
            // Admin Reviews
            [ 'name' => 'admin.review.index', 'title' => 'Access to lists of reviews' ],
            [ 'name' => 'admin.review.edit', 'title' => 'Access to editable info of review' ],
            [ 'name' => 'admin.review.store', 'title' => 'Create a review' ],
            [ 'name' => 'admin.review.update', 'title' => 'Update a review' ],
            [ 'name' => 'admin.review.destroy.soft', 'title' => 'Soft delete a review' ],
            [ 'name' => 'admin.review.destroy.hard', 'title' => 'Hard delete a review' ],
            // Admin Service Offers
            [ 'name' => 'admin.service_offer.index', 'title' => 'Access to lists of offers' ],
            [ 'name' => 'admin.service_offer.edit', 'title' => 'Access to editable info of offer' ],
            [ 'name' => 'admin.service_offer.store', 'title' => 'Create a offer' ],
            [ 'name' => 'admin.service_offer.update', 'title' => 'Update a offer' ],
            [ 'name' => 'admin.service_offer.destroy.soft', 'title' => 'Soft delete a offer' ],
            [ 'name' => 'admin.service_offer.destroy.hard', 'title' => 'Hard delete a offer' ],
            // Admin Sliders
            [ 'name' => 'admin.slider.index', 'title' => 'Access to lists of sliders' ],
            [ 'name' => 'admin.slider.by_type', 'title' => 'Access to lists of sliders' ],
            [ 'name' => 'admin.slider.edit', 'title' => 'Access to editable info of slider' ],
            [ 'name' => 'admin.slider.store', 'title' => 'Create a slider' ],
            [ 'name' => 'admin.slider.update', 'title' => 'Update a slider' ],
            [ 'name' => 'admin.slider.destroy.soft', 'title' => 'Soft delete a slider' ],
            [ 'name' => 'admin.slider.destroy.hard', 'title' => 'Hard delete a slider' ],
            // Admin Slides
            [ 'name' => 'admin.slide.index', 'title' => 'Access to lists of slides' ],
            [ 'name' => 'admin.slide.by_type', 'title' => 'Access to lists of slides' ],
            [ 'name' => 'admin.slide.edit', 'title' => 'Access to editable info of slide' ],
            [ 'name' => 'admin.slide.store', 'title' => 'Create a slide' ],
            [ 'name' => 'admin.slide.update', 'title' => 'Update a slide' ],
            [ 'name' => 'admin.slide.destroy.soft', 'title' => 'Soft delete a slide' ],
            [ 'name' => 'admin.slide.destroy.hard', 'title' => 'Hard delete a slide' ],
            // Admin Solution Categories
            [ 'name' => 'admin.solution_category.index', 'title' => 'Access to lists of solution categories' ],
            [ 'name' => 'admin.solution_category.edit', 'title' => 'Access to editable info of solution category' ],
            [ 'name' => 'admin.solution_category.store', 'title' => 'Create a solution category' ],
            [ 'name' => 'admin.solution_category.update', 'title' => 'Update a solution category' ],
            [ 'name' => 'admin.solution_category.destroy.soft', 'title' => 'Soft delete a solution category' ],
            [ 'name' => 'admin.solution_category.destroy.hard', 'title' => 'Hard delete a solution category' ],
            // Admin Solutions
            [ 'name' => 'admin.solution.index', 'title' => 'Access to lists of solutions' ],
            [ 'name' => 'admin.solution.edit', 'title' => 'Access to editable info of solution' ],
            [ 'name' => 'admin.solution.store', 'title' => 'Create a solution' ],
            [ 'name' => 'admin.solution.update', 'title' => 'Update a solution' ],
            [ 'name' => 'admin.solution.destroy.soft', 'title' => 'Soft delete a solution' ],
            [ 'name' => 'admin.solution.destroy.hard', 'title' => 'Hard delete a solution' ],
            // Works
            [ 'name' => 'admin.work.index', 'title' => 'Access to lists of works' ],
            [ 'name' => 'admin.work.edit', 'title' => 'Access to editable info of work' ],
            [ 'name' => 'admin.work.store', 'title' => 'Create a work' ],
            [ 'name' => 'admin.work.update', 'title' => 'Update a work' ],
            [ 'name' => 'admin.work.destroy.soft', 'title' => 'Soft delete a work' ],
            [ 'name' => 'admin.work.destroy.hard', 'title' => 'Hard delete a work' ],
            // Social Platform
            [ 'name' => 'admin.social_platform.index', 'title' => 'Access to lists of social platforms' ],
            [ 'name' => 'admin.social_platform.edit', 'title' => 'Access to editable info of social platform' ],
            [ 'name' => 'admin.social_platform.store', 'title' => 'Create a social platform' ],
            [ 'name' => 'admin.social_platform.update', 'title' => 'Update a social platform' ],
            [ 'name' => 'admin.social_platform.destroy.soft', 'title' => 'Soft delete a social platform' ],
            [ 'name' => 'admin.social_platform.destroy.hard', 'title' => 'Hard delete a social platform' ],
            // Text Item
            [ 'name' => 'admin.text_item.index', 'title' => 'Access to lists of text items' ],
            [ 'name' => 'admin.text_item.edit', 'title' => 'Access to editable info of text item' ],
            [ 'name' => 'admin.text_item.store', 'title' => 'Create a text item' ],
            [ 'name' => 'admin.text_item.update', 'title' => 'Update a text item' ],
            [ 'name' => 'admin.text_item.destroy.soft', 'title' => 'Soft delete a text item' ],
            [ 'name' => 'admin.text_item.destroy.hard', 'title' => 'Hard delete a text item' ],
            // Page Type
            [ 'name' => 'admin.page_type.index', 'title' => 'Access to lists of page types' ],
            [ 'name' => 'admin.page_type.edit', 'title' => 'Access to editable info of page type' ],
            [ 'name' => 'admin.page_type.store', 'title' => 'Create a page type' ],
            [ 'name' => 'admin.page_type.update', 'title' => 'Update a page type' ],
            [ 'name' => 'admin.page_type.destroy.soft', 'title' => 'Soft delete a page type' ],
            [ 'name' => 'admin.page_type.destroy.hard', 'title' => 'Hard delete a page type' ],
            // Advantage
            [ 'name' => 'advantage.index', 'title' => 'Access to lists of advantages' ],
            [ 'name' => 'advantage.edit', 'title' => 'Access to editable info of advantage' ],
            [ 'name' => 'advantage.store', 'title' => 'Create an advantage' ],
            [ 'name' => 'advantage.update', 'title' => 'Update an advantage' ],
            [ 'name' => 'advantage.destroy.soft', 'title' => 'Soft delete an advantage' ],
            [ 'name' => 'advantage.destroy.hard', 'title' => 'Hard delete an advantage' ],
            // Contact Addresses
            [ 'name' => 'contact_address.index', 'title' => 'Access to lists of addresses' ],
            [ 'name' => 'contact_address.edit', 'title' => 'Access to editable info of address' ],
            [ 'name' => 'contact_address.store', 'title' => 'Create an address' ],
            [ 'name' => 'contact_address.update', 'title' => 'Update an address' ],
            [ 'name' => 'contact_address.destroy.soft', 'title' => 'Soft delete an address' ],
            [ 'name' => 'contact_address.destroy.hard', 'title' => 'Hard delete an address' ],
            // Contact Socials
            [ 'name' => 'social.index', 'title' => 'Access to lists of socials' ],
            [ 'name' => 'social.edit', 'title' => 'Access to editable info of social' ],
            [ 'name' => 'social.store', 'title' => 'Create a social' ],
            [ 'name' => 'social.update', 'title' => 'Update a social' ],
            [ 'name' => 'social.destroy.soft', 'title' => 'Soft delete a social' ],
            [ 'name' => 'social.destroy.hard', 'title' => 'Hard delete a social' ],
            // Materials
            [ 'name' => 'material.index', 'title' => 'Access to lists of materials' ],
            [ 'name' => 'material.edit', 'title' => 'Access to editable info of material' ],
            [ 'name' => 'material.store', 'title' => 'Create a material' ],
            [ 'name' => 'material.update', 'title' => 'Update a material' ],
            [ 'name' => 'material.destroy.soft', 'title' => 'Soft delete a material' ],
            [ 'name' => 'material.destroy.hard', 'title' => 'Hard delete a material' ],
            // Pages
            [ 'name' => 'page.index', 'title' => 'Access to lists of pages' ],
            [ 'name' => 'page.edit', 'title' => 'Access to editable info of page' ],
            [ 'name' => 'page.store', 'title' => 'Create a page' ],
            [ 'name' => 'page.update', 'title' => 'Update a page' ],
            [ 'name' => 'page.destroy.soft', 'title' => 'Soft delete a page' ],
            [ 'name' => 'page.destroy.hard', 'title' => 'Hard delete a page' ],
            // Reviews
            [ 'name' => 'review.index', 'title' => 'Access to lists of reviews' ],
            [ 'name' => 'review.edit', 'title' => 'Access to editable info of review' ],
            [ 'name' => 'review.store', 'title' => 'Create a review' ],
            [ 'name' => 'review.update', 'title' => 'Update a review' ],
            [ 'name' => 'review.destroy.soft', 'title' => 'Soft delete a review' ],
            [ 'name' => 'review.destroy.hard', 'title' => 'Hard delete a review' ],
            // Service Offers
            [ 'name' => 'service_offers.index', 'title' => 'Access to lists of offers' ],
            [ 'name' => 'service_offers.edit', 'title' => 'Access to editable info of offer' ],
            [ 'name' => 'service_offers.store', 'title' => 'Create a offer' ],
            [ 'name' => 'service_offers.update', 'title' => 'Update a offer' ],
            [ 'name' => 'service_offers.destroy.soft', 'title' => 'Soft delete a offer' ],
            [ 'name' => 'service_offers.destroy.hard', 'title' => 'Hard delete a offer' ],
            // Slides
            [ 'name' => 'slide.index', 'title' => 'Access to lists of slides' ],
            [ 'name' => 'slide.edit', 'title' => 'Access to editable info of slide' ],
            [ 'name' => 'slide.store', 'title' => 'Create a slide' ],
            [ 'name' => 'slide.update', 'title' => 'Update a slide' ],
            [ 'name' => 'slide.destroy.soft', 'title' => 'Soft delete a slide' ],
            [ 'name' => 'slide.destroy.hard', 'title' => 'Hard delete a slide' ],
            // Solution Categories
            [ 'name' => 'solution_category.index', 'title' => 'Access to lists of solution categories' ],
            [ 'name' => 'solution_category.edit', 'title' => 'Access to editable info of solution category' ],
            [ 'name' => 'solution_category.store', 'title' => 'Create a solution category' ],
            [ 'name' => 'solution_category.update', 'title' => 'Update a solution category' ],
            [ 'name' => 'solution_category.destroy.soft', 'title' => 'Soft delete a solution category' ],
            [ 'name' => 'solution_category.destroy.hard', 'title' => 'Hard delete a solution category' ],
            // Solutions
            [ 'name' => 'solution.index', 'title' => 'Access to lists of solutions' ],
            [ 'name' => 'solution.edit', 'title' => 'Access to editable info of solution' ],
            [ 'name' => 'solution.store', 'title' => 'Create a solution' ],
            [ 'name' => 'solution.update', 'title' => 'Update a solution' ],
            [ 'name' => 'solution.destroy.soft', 'title' => 'Soft delete a solution' ],
            [ 'name' => 'solution.destroy.hard', 'title' => 'Hard delete a solution' ],
            // Building Type
            [ 'name' => 'reference.building_type.index', 'title' => 'Access to lists of building types' ],
            [ 'name' => 'reference.building_type.edit', 'title' => 'Access to editable info of building type' ],
            [ 'name' => 'reference.building_type.store', 'title' => 'Create a building type' ],
            [ 'name' => 'reference.building_type.update', 'title' => 'Update a building type' ],
            [ 'name' => 'reference.building_type.destroy.soft', 'title' => 'Soft delete a building type' ],
            [ 'name' => 'reference.building_type.destroy.hard', 'title' => 'Hard delete a building type' ],
            // Building Stage
            [ 'name' => 'reference.building_stage.index', 'title' => 'Access to lists of building stages' ],
            [ 'name' => 'reference.building_stage.edit', 'title' => 'Access to editable info of building stage' ],
            [ 'name' => 'reference.building_stage.store', 'title' => 'Create a building stage' ],
            [ 'name' => 'reference.building_stage.update', 'title' => 'Update a building stage' ],
            [ 'name' => 'reference.building_stage.destroy.soft', 'title' => 'Soft delete a building stage' ],
            [ 'name' => 'reference.building_stage.destroy.hard', 'title' => 'Hard delete a building stage' ],
            // Project Stage
            [ 'name' => 'reference.project_stage.index', 'title' => 'Access to lists of project stages' ],
            [ 'name' => 'reference.project_stage.edit', 'title' => 'Access to editable info of project stage' ],
            [ 'name' => 'reference.project_stage.store', 'title' => 'Create a project stage' ],
            [ 'name' => 'reference.project_stage.update', 'title' => 'Update a project stage' ],
            [ 'name' => 'reference.project_stage.destroy.soft', 'title' => 'Soft delete a project stage' ],
            [ 'name' => 'reference.project_stage.destroy.hard', 'title' => 'Hard delete a project stage' ],
        ];
        
        foreach ($data as $item) {
            Permission::firstOrCreate($item + ['guard_name' => 'api']);
        }
    }
}
