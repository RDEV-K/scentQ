<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeedWithGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
        $faqs = [
            [
                'faq_group_id' => 1, //General
                'question' => "Sales Tax Policy at ScentQ",
                'answer' => "If you're curious about whether ScentQ applies sales tax, the best way to find out is by visiting their official website, checking their terms and conditions, or getting in touch with their customer support team. They'll offer you the most current and accurate details about their sales tax policy and if it applies to their products.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "Understanding the Queue and Its Operations",
                'answer' => "Enqueue Operation: This action involves adding an element to the end of the queue, effectively expanding its size by one.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "Enhancing Your Fragrance Suggestions: Why Rating Matters",
                'answer' => "Description: Giving Feedback: A crucial aspect of refining fragrance recommendations is user input. By taking a moment to rate and review the fragrances you've experienced, you contribute to a system that better understands your tastes, leading to more personalized suggestions.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "Purchasing Additional Fragrance Cases Made Easy",
                'answer' => "Step 1: Identify the Brand and Model
                To buy extra fragrance cases, start by locating the brand and model of your current case. You can typically find this information on the original packaging or directly on the case. Knowing these specifics ensures a perfect match with your existing fragrance.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "Experiencing Website Issues? Here's a Quick Fix!",
                'answer' => "If you're encountering difficulties with the website, clearing your browser cache can often do the trick. Head to your browser settings and locate the option to clear browsing data or cache. Choose the suitable time range and proceed to clear the cache. This should help resolve temporary glitches and enhance the website's performance.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "ScentQ's Fragrance Collection",
                'answer' => "ScentQ boasts an extensive selection of designer fragrances sourced from renowned fashion houses and luxury brands. Each scent embodies the distinct style of the brand and is crafted by celebrated perfumers.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "Can't Find Your Desired Scent?",
                'answer' => "If you're on the hunt for a particular fragrance, consider exploring various brands or specialty fragrance stores. They often offer a broader range and may carry unique scents that you won't find elsewhere. Happy hunting!",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "Ensuring Authenticity: Are These Genuine Scents?",
                'answer' => "To enhance the certainty of obtaining authentic scents, it is recommended to make purchases from authorized retailers, official brand stores, or reputable online platforms. These sources are more likely to offer genuine products.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "Getting Started with Your New Case",
                'answer' => "Begin by thoroughly reviewing any accompanying instructions or user manuals that come with the case. These materials offer precise guidance on how to use it correctly and may highlight any special features or considerations. This ensures you get the most out of your new case.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "Empty Queue in Task or Job System",
                'answer' => "In a task or job queue system, having an empty queue implies that there are no pending tasks or jobs awaiting execution. This may lead to a temporary halt in activity or processing until new tasks are introduced to the queue. Conversely, it could indicate that all scheduled or queued tasks have been successfully completed, which might be the intended outcome.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "Canceling Your Subscription: A Step-by-Step Guide",
                'answer' => "Begin by examining the terms and conditions, as well as any accompanying documentation pertaining to your subscription. Make sure to familiarize yourself with the cancellation policy, including any specified notice periods or requirements for cancellation. This will help you navigate the process smoothly.",
            ],
            [
                'faq_group_id' => 1, //General
                'question' => "What is ScentQ?",
                'answer' => "ScentQ is a well-known online perfume retailer, catering to both men and women with a diverse array of fragrances. This platform offers a seamless experience for customers to explore and acquire perfumes from a variety of brands. Their selection includes sought-after designer scents, niche fragrances, and exclusive collections.",
            ],

            [
                'faq_group_id' => 2, // My Account
                'question' => "Updating Your Profile Information: A Quick Guide",
                'answer' => "Begin by visiting the website or application linked to your profile. Sign in using your designated username and password.",
            ],
            [
                'faq_group_id' => 2, // My Account
                'question' => "Updating Your Account Email Address",
                'answer' => "Begin by visiting the website or application linked to your account. Sign in using your current email address and password.",
            ],
            [
                'faq_group_id' => 2, // My Account
                'question' => "I need to update my profile information. How do I do that?",
                'answer' => "Visit the website or application associated with your profile and sign in using your username and password.",
            ],

            [
                'faq_group_id' => 3, // Subscription
                'question' => "Refund Policy",
                'answer' => "At ScentQ, we prioritize your satisfaction and aim to address various scenarios with our comprehensive refund policy. We gladly provide full refunds for items that arrive damaged or are found to be defective beyond repair. Please note that subscription orders are generally non-returnable, except for cases involving damaged or defective items. Certain standalone purchases may be eligible for return within a specified timeframe, in exchange for site credit. For detailed information about our refund policy, including eligibility criteria and step-by-step procedures, please refer to the respective sections. Rest assured, our main focus is on delivering high-quality products, and we are dedicated to swiftly and effectively resolving any concerns you may have.",
            ],
            [
                'faq_group_id' => 3, // Subscription
                'question' => "What are my subscription options?",
                'answer' => "Navigate to your subscription settings. Look for an option or section in your account settings that specifically relates to your subscription. It may be labelled as 'Subscription,' 'Billing,' or something similar.",
            ],
            [
                'faq_group_id' => 3, // Subscription
                'question' => "How can I view my one-time purchase or eCommerce history?",
                'answer' => "Access your account settings: Look for an option that allows you to access your account settings or order history. This is typically found in the account or profile section of the website or platform.",
            ],
            [
                'faq_group_id' => 3, // Subscription
                'question' => "How can I view my one-time purchase or eCommerce history?",
                'answer' => "Log in to your account. Visit the website or platform associated with your subscription and sign in using your credentials. Access your account settings: Look for an option that allows you to manage your subscription or account settings. This is typically found in the account or profile section of the website or platform.",
            ],
            [
                'faq_group_id' => 3, // Subscription
                'question' => "Why do some fragrances have a premium price?",
                'answer' => "Quality and Rarity of Ingredients: Fragrances that utilise high-quality, rare, or exotic ingredients often come with a premium price. These ingredients can be more expensive to source, extract, or cultivate, resulting in a higher overall production cost.",
            ],
            [
                'faq_group_id' => 3, // Subscription
                'question' => "Modifying Your Queued Product: Time Frame",
                'answer' => "You can make changes to your queued product up until the next monthly bill is generated, providing you with ample flexibility.",
            ],
            [
                'faq_group_id' => 3, // Subscription
                'question' => "What do i get?",
                'answer' => "Access to features and functionality: By creating an account or using a platform or service, you gain access to various features and functionality offered by that platform. This could include the ability to create and edit content, interact with other users, customise settings, or perform specific actions based on the platform's purpose.",
            ],
            [
                'faq_group_id' => 3, // Subscription
                'question' => "How can I upgrade my plan?",
                'answer' => "Log in to your account. Visit the website or application associated with the service or platform you are using, and log in using your credentials.",
            ],
            [
                'faq_group_id' => 3, // Subscription
                'question' => "How can I view or change my subscription plan?",
                'answer' => "Log in to your account: Visit the website or application associated with the service or platform you are subscribed to and log in using your credentials.",
            ],
            [
                'faq_group_id' => 3, // Subscription
                'question' => "I need a break. Can I skip a few months subscription?",
                'answer' => "Review the terms and conditions: Check the terms and conditions or the subscription agreement of the service or platform you are subscribed to. Look for information about pausing or skipping your subscription.",
            ],

            [
                'faq_group_id' => 4, // Billing & Shipping
                'question' => "Shipping Locations at ScentQ",
                'answer' => "ScentQ endeavors to ship to a range of locations in accordance with their shipping policy. While specific destinations may be subject to change or restrictions, they generally aim to provide international shipping to cater to a diverse customer base. As you proceed through the checkout process on their website, you'll have the opportunity to input your shipping address and confirm if they serve your specific location. Should you have any uncertainties about their shipping policy or any specific queries, it's advisable to contact ScentQ's customer support for the most current and accurate information regarding shipping destinations.",
            ],
            [
                'faq_group_id' => 4, // Billing & Shipping
                'question' => "I just placed an order! When will it ship?",
                'answer' => "After your order is processed and dispatched, keep an eye on your inbox for a shipping confirmation email. This message will include valuable tracking information, enabling you to follow the journey of your package. Please note, the estimated delivery date will be influenced by your chosen shipping method and the distance between the company's location and your delivery address. Happy anticipating!",
            ],
            [
                'faq_group_id' => 4, // Billing & Shipping
                'question' => "How do I update my shipping address?",
                'answer' => "Log in to your account. Visit the website or platform associated with your order and sign in using your credentials.",
            ],
            [
                'faq_group_id' => 4, // Billing & Shipping
                'question' => "How do I update my billing information?",
                'answer' => "Log in to your account. Visit the website or platform associated with your subscription or purchase and sign in using your credentials. Access your account settings: Look for an option that allows you to manage your account or billing settings. This is typically found in the account or profile section of the website or platform.",
            ],
            [
                'faq_group_id' => 4, // Billing & Shipping
                'question' => "When will I receive my perfume?",
                'answer' => "Processing Time: Once you place an order, the company will typically require some time to process and prepare your perfume for shipment. This processing time can vary and is often mentioned on the website or during the checkout process.",
            ],
            [
                'faq_group_id' => 4, // Billing & Shipping
                'question' => "Where can I find my billing date?",
                'answer' => "Log in to your account. Visit the website or platform associated with your subscription and sign in using your credentials.",
            ],
            [
                'faq_group_id' => 4, // Billing & Shipping
                'question' => "When can I expect to be billed for my subscription?",
                'answer' => "If you have a monthly subscription, you can generally expect to be billed on the same date each month. For example, if you signed up for a monthly subscription on the 10th of the month, you would typically be billed on the 10th of every subsequent month.",
            ],

            [
                'faq_group_id' => 5, //Order & Tracking
                'question' => "Can I return my ScentQ order?",
                'answer' => "Visit ScentQ's website or check the documentation that came with your order to familiarise yourself with their return policy. Pay attention to any specific requirements or timeframes for initiating a return.",
            ],
            [
                'faq_group_id' => 5, //Order & Tracking
                'question' => "Help! I never received my product!",
                'answer' => "Step 1: Double-Check the Delivery Status. Step 2: Start by verifying the tracking information for your order. This will provide insights into any updates and indicate if the package has been delivered. Keep an eye out for any delivery attempts or notifications that may have been left by the courier. This information will help us get to the bottom of the situation.",
            ],
            [
                'faq_group_id' => 5, //Order & Tracking
                'question' => "How do I track my order?",
                'answer' => "Locate your tracking number. Check your order confirmation email or account dashboard on the website or platform from which you made the purchase. The tracking number is usually provided along with the shipping information.",
            ],
            [
                'faq_group_id' => 5, //Order & Tracking
                'question' => "Are there consequences if I cancel?",
                'answer' => "Loss of access or benefits: Cancelling your subscription may result in the loss of access to certain features, content, or benefits associated with the subscription. This could include exclusive content, discounts, or privileges that were available to subscribers.",
            ],
            [
                'faq_group_id' => 5, //Order & Tracking
                'question' => "What should i do about a damaged product",
                'answer' => "Document the damage: Take clear photos or videos of the damaged product, highlighting the specific areas of concern. This evidence will be helpful when contacting customer support or initiating a return or refund process.",
            ],
            [
                'faq_group_id' => 5, //Order & Tracking
                'question' => "I haven't received my scent order yet. When will it be in my mailbox?",
                'answer' => "Check shipping information: Review the shipping details provided by ScentQ, including the estimated delivery time frame. This information is typically sent to you via email or can be found in your order confirmation.",
            ],
        ];

        Faq::truncate();

        foreach ($faqs as $key => $faq) {

            Faq::create([
                'faq_group_id' => $faq['faq_group_id'],
                'question' => $faq['question'],
                'answer' => $faq['answer'],
            ]);
        }
    }
}
