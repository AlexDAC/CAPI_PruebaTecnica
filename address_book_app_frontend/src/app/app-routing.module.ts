import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ContactTableComponent } from './components/contacts/contact-table/contact-table.component';
import { ContactTabsComponent } from './components/contacts/contact-tabs/contact-tabs.component';

const routes: Routes = [
  { path: 'contacts', component: ContactTableComponent},
  { path: 'contacts/new', component: ContactTabsComponent},
  { path: 'contacts/:id/edit', component: ContactTabsComponent},
  { path: '', redirectTo: 'contacts', pathMatch: 'full'},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
